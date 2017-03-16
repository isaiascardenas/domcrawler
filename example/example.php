<?php

require __DIR__ . '/../vendor/autoload.php';

// use IsaiasCardenas\CorreosChile\Domcrawler;

// $domCrawler = new Domcrawler('RE127140035DE');

// $json = json_decode($domCrawler->getData());
// echo json_encode($json, JSON_PRETTY_PRINT);
use IsaiasCardenas\Domcrawler\CorreosRequest;

$test = new CorreosRequest();
var_dump($test->getHtml('RE127140035DE'));

// echo $test->getHtml('RE127140035DE');
