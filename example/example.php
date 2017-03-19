<?php

require __DIR__ . '/../vendor/autoload.php';

// Plugin Test

use IsaiasCardenas\Domcrawler\Domcrawler;

$domCrawler = new Domcrawler();
$json = json_decode($domCrawler->parse('905619194', 'starken'));
echo json_encode($json, JSON_PRETTY_PRINT);

//__Domcrawler Test__

// use IsaiasCardenas\Domcrawler\domcrawlers\CorreosDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\ChilexpressDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\StarkenDomcrawler;

// $domCrawler = new StarkenDomcrawler('905619194');
// var_dump($domCrawler->test());
//__Request Test__

// use IsaiasCardenas\Domcrawler\requests\CorreosRequest;
// use IsaiasCardenas\Domcrawler\requests\ChilexpressRequest;
// use IsaiasCardenas\Domcrawler\requests\StarkenRequest;

// $request = new StarkenRequest();
// var_dump($request->getHtml('905619194'));
