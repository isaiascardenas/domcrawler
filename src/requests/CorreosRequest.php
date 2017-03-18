<?php

namespace IsaiasCardenas\Domcrawler\requests;

use IsaiasCardenas\Domcrawler\requests\Request;

class CorreosRequest extends Request
{
	const URL_TRACKING = 'http://seguimientoweb.correos.cl/ConEnvCorreos.aspx';
	const TOKEN = 'Cor398-cc';
	
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
		return $this->client->request('POST', $url, [
			'form_params' => [
				'obj_key' => self::TOKEN,
				'obj_env' => $trackingNumber,
				]
			]);
	}
}
