<?php

require 'vendor/autoload.php';

use IsaiasCardenas\CorreosChile\Domcrawler;

$domCrawler = new Domcrawler('RT993112324DE');
echo "<pre>";
echo $domCrawler->getData();
// echo $domCrawler->getHistory();
echo "<pre>";

// $domCrawler->getHtml();
