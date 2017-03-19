<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

use IsaiasCardenas\Domcrawler\requests\StarkenRequest;
use Symfony\Component\DomCrawler\Crawler;
use IsaiasCardenas\Domcrawler\domcrawlers\AbstractCrawler;

class StarkenDomcrawler extends AbstractCrawler
{
	const GENERAL_TABLE = '#detSeg1 > div > div > div.modal-body > div.row.envio.envio-estado > div.estado.estado-detalle.clearfix';
	const DELIVERY_TABLE = '#detSeg1 > div > div > div.modal-body > div.row.envio.envio-estado > div.mensaje.mensaje-homologado-7 > p';

	public function __construct($trackingCode)
	{
		$request = new StarkenRequest();
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

	protected function getHistory()
	{
		if ($this->exist) {
			$history = [];
			$crawler = $this->crawler->filter(self::GENERAL_TABLE)->children();
			$history = $crawler->each(function (Crawler $node, $i) {

				return [
					'sendingStatus' => $node->text(),
				];
			});
			return $history;
		}
		return [];
	}

	protected function parseDeliveryTable()
	{
		try {
			$deliveredTo = $this->cleanName(
				$crawler = $this->crawler
				->filter(self::DELIVERY_TABLE)
				->text()
			);
			$this->delivered = true;

			return [
				'deliveredTo' => $deliveredTo
			];
		} catch (\InvalidArgumentException $e) {
			return [];
		}
	}

	protected function parseGeneralTable()
	{
		if ($this->exist) {
			return [
				'sendingStatus' => $this->crawler
					->filter(self::GENERAL_TABLE)
					->children()
					->last()
					->text()
			];
		}
		return [];
	}

	private function cleanName($string)
	{
		return trim(substr($string, 25), ' ');
	}
}
