<?php

namespace IsaiasCardenas\Domcrawler;

use GuzzleHttp\Client;

class Request
{
	protected $client;
		
	function __construct()
	{
		$this->client = new Client();
	}

	public function getHtml($trackingNumber)
	{
		
	}

	protected function get($url, $trackingNumber)
	{
			
	}
}
