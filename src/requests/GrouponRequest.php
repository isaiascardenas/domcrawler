<?php

namespace IsaiasCardenas\Domcrawler\requests;

use IsaiasCardenas\Domcrawler\requests\Request;

class GrouponRequest extends Request
{
	const URL_TRACKING = 'http://www.groupontracking.com/';
	
	function __construct()
	{
		parent::__construct();
	}

	public function getHtml($trackingNumber)
	{
		return $this->get(self::URL_TRACKING, $trackingNumber)
			->getBody()
			->getContents();
	}

	protected function get($url, $trackingNumber)
	{
		return $this->client->request('GET', $url . $trackingNumber);
	}
}
