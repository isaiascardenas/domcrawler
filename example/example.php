<?php

require __DIR__ . '/../vendor/autoload.php';

use IsaiasCardenas\CorreosChile\Domcrawler;

$domCrawler = new Domcrawler('RE127140035DE');

$json = json_decode($domCrawler->getData());
echo json_encode($json, JSON_PRETTY_PRINT);
