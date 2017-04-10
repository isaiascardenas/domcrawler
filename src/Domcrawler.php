<?php

namespace IsaiasCardenas\Domcrawler;

use IsaiasCardenas\Domcrawler\domcrawlers\CorreosDomcrawler;
use IsaiasCardenas\Domcrawler\domcrawlers\ChilexpressDomcrawler;
use IsaiasCardenas\Domcrawler\domcrawlers\StarkenDomcrawler;
use IsaiasCardenas\Domcrawler\domcrawlers\DhlGlobalMailDomcrawler;

class Domcrawler
{
	static private $crawlers  = [
		'correos' => CorreosDomcrawler::class,
		'chilexpress' => ChilexpressDomcrawler::class,
		'starken' => StarkenDomcrawler::class,
		'dhlgm' => DhlGlobalMailDomcrawler::class,
	];

	static public function parse($trackingCode, $platform)
	{
		$domcrawler = new self::$crawlers[$platform]($trackingCode);
		return $domcrawler->getData();
	}
}
