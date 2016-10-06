<?php

namespace IsaiasCardenas\CorreosChile;

use IsaiasCardenas\CorreosChile\Request;
use Symfony\Component\DomCrawler\Crawler;

class Domcrawler
{
    private $crawler;
    private $delivered;
    private $exist;
    private $tracking;
    const GENERAL_TABLE = '#pnlEnvio > table';
    const DELIVERY_TABLE = '#Panel_Entrega > table';

    public function __construct($trackingCode)
    {
        try {
            $request = new Request();
            $this->crawler = new Crawler($request->getHtml($trackingCode));
            $this->exist = true;
            $this->delivered = false;
            $this->tracking = $trackingCode;
        } catch (Exception $e) {
            $this->exist = false;
        }
    }

    public function getData()
    {
        $data = [
            'general_table' => $this->parseGeneralTable(),
            'delivery_table' => $this->parseDeliveryTable(),
        ];

        return json_encode([
            'exist' => $this->exist,
            'delivered' => $this->delivered,
            'tracking_number' => $this->tracking,
            'data' => $data,
            'history' => $this->getHistory(),
        ]);
    }

    private function getHistory()
    {
        $crawler = $this->crawler->filter(self::GENERAL_TABLE)->children();
        return $this->extractHistory($crawler);
    }

    private function parseDeliveryTable()
    {
        try {
            $crawler = $this->crawler
            ->filter(self::DELIVERY_TABLE)
            ->eq(0);

            $deliveredDate = $this->extractDate($crawler);
            $deliveredTo = $this->extractName($crawler);
            $deliveredToRut = $this->extractRut($crawler);
    
            $this->delivered = true;

            return [
                'deliveredDate' => $deliveredDate,
                'deliveredTo' => $deliveredTo,
                'deliveredToRut' => $deliveredToRut,
            ];
        } catch (Exception $e) {
            return [];
        }
    }

    private function parseGeneralTable()
    {
        $crawler = $this->crawler->filter(self::GENERAL_TABLE)->children();
        $data = $this->extractData($crawler);

        return [
            'sendingStatus' => $data['sendingStatus'],
            'sendingDate' => $data['sendingDate'],
        ];
    }

    private function extractDate($crawler)
    {
        foreach ($crawler as $node) {
            $date = $node
            ->lastChild
            ->firstChild
            ->nextSibling
            ->nextSibling
            ->nodeValue;
            return trim(substr($date, 4, -2), ' ');
        }
    }

    private function extractName($crawler)
    {
        foreach ($crawler as $node) {
            $name = $node
                ->firstChild
                ->lastChild
                ->previousSibling
                ->nodeValue;
            return trim(substr($name, 4, -2), ' ');
        }
    }

    private function extractRut($crawler)
    {
        foreach ($crawler as $node) {
            $rut = $node
                ->lastChild
                ->lastChild
                ->previousSibling
                ->nodeValue;
             return trim(substr($rut, 4, -2), ' ');
        }
    }

    private function extractData($crawler)
    {
        foreach ($crawler as $key => $node) {
            if ($key != 0) {
                $status = $node->firstChild->nodeValue;
                $status = trim(substr($status, 4, -3), ' ');
                $date = $node->firstChild->nextSibling->nextSibling->nodeValue;
                $date = trim(substr($date, 0, -3), ' ');

                return [
                    'sendingStatus' => $status,
                    'sendingDate' => $date,
                ];
            }
        }
        
    }

    private function extractHistory($crawler)
    {
        $history = [];
        foreach ($crawler as $key => $node) {
            if ($key != 0) {
                $status = $node->firstChild->nodeValue;
                $status = trim(substr($status, 4, -3), ' ');
                $date = $node->firstChild->nextSibling->nextSibling->nodeValue;
                $date = trim(substr($date, 0, -3), ' ');
                $office = $node->lastChild->previousSibling->nodeValue;
                $office = trim(substr($office, 4, -3), ' ');

                $history[] = [
                    'sendingStatus' => $status,
                    'sendingDate' => $date,
                    'sendingOffice' => $office,
                ];
            }
        }
        return $history;
    }
}
