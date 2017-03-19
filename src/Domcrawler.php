<?php

namespace IsaiasCardenas\Domcrawler;

use IsaiasCardenas\Domcrawler\domcrawlers\CorreosDomcrawler;
use IsaiasCardenas\Domcrawler\domcrawlers\ChilexpressDomcrawler;
use IsaiasCardenas\Domcrawler\domcrawlers\StarkenDomcrawler;

class Domcrawler
{
	private $crawlers;

	public function __construct()
	{
		$this->crawlers = [
			'correos' => CorreosDomcrawler::class,
			'chilexpress' => ChilexpressDomcrawler::class,
			'starken' => StarkenDomcrawler::class,
		];
	}

	public function parse($trackingCode, $platform)
	{
		$domcrawler = new $this->crawlers[$platform]($trackingCode);
		return $domcrawler->parse();
	}
}
