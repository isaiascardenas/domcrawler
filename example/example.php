<?php

require __DIR__ . '/../vendor/autoload.php';

// __Plugin Test__

use IsaiasCardenas\Domcrawler\Domcrawler;

$json = json_decode(Domcrawler::parse('GM275322484006032509', 'dhlgm'));
echo json_encode($json, JSON_PRETTY_PRINT);

// __Domcrawler Test__

// use IsaiasCardenas\Domcrawler\domcrawlers\CorreosDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\ChilexpressDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\StarkenDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\GrouponDomcrawler;
// use IsaiasCardenas\Domcrawler\domcrawlers\DhlGlobalMailDomcrawler;

// $domCrawler = new DhlGlobalMailDomcrawler('GM275322484006032509');
// var_dump($domCrawler->test());

// __Request Test__

// use IsaiasCardenas\Domcrawler\requests\CorreosRequest;
// use IsaiasCardenas\Domcrawler\requests\ChilexpressRequest;
// use IsaiasCardenas\Domcrawler\requests\StarkenRequest;
// use IsaiasCardenas\Domcrawler\requests\GrouponRequest;
// use IsaiasCardenas\Domcrawler\requests\DhlGlobalMailRequest;

// $request = new DhlGlobalMailRequest();
// var_dump($request->getHtml('GM275322484006032509'));
