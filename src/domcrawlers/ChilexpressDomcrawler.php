<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

use IsaiasCardenas\Domcrawler\requests\ChilexpressRequest;
use Symfony\Component\DomCrawler\Crawler;
use IsaiasCardenas\Domcrawler\domcrawlers\CrawlerInterface;

class ChilexpressDomcrawler implements CrawlerInterface
{
	private $crawler;
	private $delivered;
	private $exist;
	private $tracking;
	const GENERAL_TABLE = '#organic-content > table';
	const DELIVERY_TABLE = '#organic-content > section';
	const DELIVERY_TABLE_PATH = 'div > ul > li > ul';

	public function __construct($trackingCode)
	{
		$request = new ChilexpressRequest();
		$this->crawler = new Crawler($request->getHtml($trackingCode));
		try {
			$error = $this->crawler
				->filter(self::GENERAL_TABLE)
				->attr('class');
			$this->exist = true;
			$this->delivered = false;
			$this->tracking = $trackingCode;
		} catch (\InvalidArgumentException $e) {
			$this->exist = false;
			$this->delivered = false;
			$this->tracking = $trackingCode;
		}
	}

	public function parse()
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

	public function getHistory()
	{
		if ($this->exist) {
			$crawler = $this->crawler->filter(self::GENERAL_TABLE)->children();
			return $this->extractHistory($crawler);
		}
		return [];
	}

	private function parseDeliveryTable()
	{
		try {
			$crawler = $this->crawler
			->filter(self::DELIVERY_TABLE)
			->last()
			->filter(self::DELIVERY_TABLE_PATH)
			->children();

			$nodeValues = $crawler->each(function (Crawler $node, $i) {
		    return $node->text();
			});

			$deliveredDate = $this->cleanDate($nodeValues[1], $nodeValues[2]);
			$deliveredTo = $this->cleanName($nodeValues[3]);

			$this->delivered = true;

			return [
				'deliveredDate' => $deliveredDate,
				'deliveredTo' => $deliveredTo
			];
		} catch (\InvalidArgumentException $e) {
			return [];
		}
	}

	private function parseGeneralTable()
	{
		if ($this->exist) {
			$crawler = $this->crawler->filter(self::GENERAL_TABLE)->children();
			$data = $this->extractData($crawler);

			return [
				'sendingStatus' => $data['sendingStatus'],
				'sendingDate' => $data['sendingDate'],
			];
		}
		return [];
	}

	private function cleanDate($date, $hour)
	{
		return trim(substr($date, 16), ' ') . ' ' . trim(substr($hour, 15), ' ');
	}

	private function cleanName($string)
	{
		return trim(substr($string, 18, -12), ' ');
	}

	private function extractData($crawler)
	{
		foreach ($crawler as $key => $node) {

			if ($key != 0) {
				$status = $node
					->firstChild
					->firstChild
					->nextSibling
					->nextSibling
					->nodeValue;

				$date = $node
					->firstChild
					->firstChild
					->nodeValue
					. ' ' . 
					$node
					->firstChild
					->firstChild
					->nextSibling
					->nodeValue;

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
				$status = $node
					->firstChild
					->firstChild
					->nextSibling
					->nextSibling
					->nodeValue;

				$date = $node
					->firstChild
					->firstChild
					->nodeValue
					. ' ' . 
					$node
					->firstChild
					->firstChild
					->nextSibling
					->nodeValue;

				$history[] = [
					'sendingStatus' => $status,
					'sendingDate' => $date,
				];
			}
		}
		return $history;
	}
}
