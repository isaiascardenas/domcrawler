<?php

namespace IsaiasCardenas\Domcrawler\requests;

use GuzzleHttp\Client;

abstract class Request
{
	protected $client;
		
	function __construct()
	{
		$this->client = new Client();
	}

	abstract public function getHtml($trackingNumber);
	abstract protected function get($url, $trackingNumber);
}
