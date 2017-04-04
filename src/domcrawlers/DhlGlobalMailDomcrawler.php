<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

use IsaiasCardenas\Domcrawler\requests\DhlGlobalMailRequest;
use Symfony\Component\DomCrawler\Crawler;
use IsaiasCardenas\Domcrawler\domcrawlers\AbstractCrawler;

class DhlGlobalMailDomcrawler extends AbstractCrawler
{
	const GENERAL_TABLE = '#wrap 
		> div.container.details 
		> div > div.col-md-8 
		> ol';
	const GENERAL_TABLE_DATE = 'li.timeline-event.timeline-last 
		> div.timeline-time';
	const GENERAL_TABLE_STATUS = 'li.timeline-event.timeline-last 
		> div.timeline-unit > div.timeline-description';
	const DELIVERY_TABLE = '#wrap > div.container.details > div > div.col-md-8 > div.card.card-delivered';

	public function __construct($trackingCode)
	{
		$request = new DhlGlobalMailRequest();
		$this->crawler = new Crawler($request->getHtml($trackingCode));
		try {
			$error = $this->crawler
				->filter(self::GENERAL_TABLE)
				->attr('class');
			$this->exist = true;
			$this->deliverde = false;
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
			$data = [];
			$crawler = $this->crawler
				->filter(self::GENERAL_TABLE)
				->children()
				->first()
				->nextAll();

			$data = $crawler->each(function (Crawler $node, $i) use ($data) {
				try {
					if ($node->attr('class') == 'timeline-date') {
						return $node->text();
					}
					return [
						'date' => $node
							->filter('.timeline-time')
							->text(),
						'status' => $node
							->filter('div.timeline-unit > div.timeline-description')
							->text(),
					];
				} catch (\InvalidArgumentException $e) {
					return ;
				}
			});

			$history = [];
			$date = '';
			foreach ($data as $element) {
				if (!is_null($element)) {
					if (is_array($element)) {
						$history[] = [
							'sendingStatus' => $element['status'],
							'sendingDate' => $date . ' ' .$element['date'],
						];
					} else {
						$date = $element;
					}
				}
			}
			return $history;
		}
		return [];
	}

	protected function parseDeliveryTable()
	{
		try {

			$deliveredDate = $this->crawler
				->filter(self::DELIVERY_TABLE)
				->filter('div.status-info > p')
				->text();

			$deliveredTo = $this->crawler
				->filter(self::DELIVERY_TABLE)
				->filter('div.row')
				->children()
				->eq(1)
				->text();

			$deliveredFrom = $this->crawler
				->filter(self::DELIVERY_TABLE)
				->filter('div.row')
				->children()
				->eq(0)
				->text();

			$this->delivered = true;

			return [
				'deliveredDate' => $this->cleanDate($deliveredDate),
				'deliveredTo' => $this->cleanText($deliveredTo),
				'deliveredFrom' => $this->cleanText($deliveredFrom),
			];
		} catch (\InvalidArgumentException $e) {
			return [];
		}
	}

	protected function parseGeneralTable()
	{
		if ($this->exist) {

			$sendingStatus = $this->crawler
				->filter(self::GENERAL_TABLE)
				->filter(self::GENERAL_TABLE_STATUS)
				->text();

			$sendingDate = $this->crawler
				->filter(self::GENERAL_TABLE)
				->filter(self::GENERAL_TABLE_DATE)
				->text();

			return [
				'sendingStatus' => $sendingStatus,
				'sendingDate' => $sendingDate,
			];
		}
		return [];
	}

	private function cleanText($string)
	{
		return trim(substr($string, 15, -10) , "\t");
	}

	private function cleanDate($string)
	{
		return substr(trim(substr($string, 3) , "\t"), 0, -2);
	}
}
