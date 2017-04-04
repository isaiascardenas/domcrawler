<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

use IsaiasCardenas\Domcrawler\requests\GrouponRequest;
use Symfony\Component\DomCrawler\Crawler;
use IsaiasCardenas\Domcrawler\domcrawlers\AbstractCrawler;

class GrouponDomcrawler extends AbstractCrawler
{
	const GENERAL_TABLE = '#status-inner > div.historicTrack > table';
	const DELIVERY_TABLE = '';

	public function __construct($trackingCode)
	{
		$request = new GrouponRequest();
		$this->crawler = new Crawler($request->getHtml($trackingCode));
		// try {
		// 	$error = $this->crawler
		// 		->filter(self::GENERAL_TABLE)
		// 		->attr('class');
			$this->exist = true;
			$this->delivered = false;
			$this->tracking = $trackingCode;
		// } catch (\InvalidArgumentException $e) {
			// $this->exist = false;
			// $this->delivered = false;
			// $this->tracking = $trackingCode;
		// }
	}

	public function test()
	{
		return $this->parseDeliveryTable();
	}

	protected function getHistory()
	{
		if ($this->exist) {
			$history = [];
			$crawler = $this->crawler
				->filter(self::GENERAL_TABLE)
				->filter('tbody')
				->children();
			$history = $crawler->each(function (Crawler $node, $i) {
				$data = $node->children();
				$status = $this->cleanStatus($data->first()->text());
				$date = $this->cleanDate($data);

				return [
					'sendingStatus' => $status,
					'sendingDate' => $date,
				];
			});
			return $history;
		}
		return [];
	}

	protected function parseDeliveryTable()
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

	protected function parseGeneralTable()
	{
		if ($this->exist) {
			$crawler = $this->crawler
				->filter(self::GENERAL_TABLE)
				->filter('tbody > .lastTrack')
				->children();

			$status = $this->cleanStatus($crawler->first()->text());
			$date = $this->cleanDate($crawler);

			return [
				'sendingStatus' => $status,
				'sendingDate' => $date,
			];
		}
		return [];
	}

	private function cleanStatus($string)
	{
		return explode(":", $string)[0];
	}

	private function cleanDate($crawler)
	{
		return $crawler->eq(1)->text() . " " . $crawler->eq(2)->text();
	}
}
