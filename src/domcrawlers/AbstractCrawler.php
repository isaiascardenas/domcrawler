<?php

namespace IsaiasCardenas\Domcrawler\domcrawlers;

abstract class AbstractCrawler
{
	protected $crawler;
	protected $delivered;
	protected $exist;
	protected $tracking;

  abstract protected function parseGeneralTable();
  abstract protected function parseDeliveryTable();
	abstract protected function getHistory();

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
}
