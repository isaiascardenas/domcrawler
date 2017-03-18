<?php

require __DIR__ . '/../vendor/autoload.php';

// Plugin Test

use IsaiasCardenas\Domcrawler\Domcrawler;

$domCrawler = new Domcrawler();
$json = json_decode($domCrawler->parse('RT914943865HK', 'correos'));
echo json_encode($json, JSON_PRETTY_PRINT);

//__Domcrawler Test__

// use IsaiasCardenas\Domcrawler\domcrawlers\CorreosDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\ChilexpressDomcrawler;

// $domCrawler = new ChilexpressDomcrawler('99605900472');
// $json = json_decode($domCrawler->parse());
// echo json_encode($json, JSON_PRETTY_PRINT);

//__Request Test__

// use IsaiasCardenas\Domcrawler\requests\CorreosRequest;
// use IsaiasCardenas\Domcrawler\requests\ChilexpressRequest;
// use IsaiasCardenas\Domcrawler\requests\StarkenRequest;

// $request = new StarkenRequest();
// var_dump($request->getHtml('99605900472'));
