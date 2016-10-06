<?php

require '../vendor/autoload.php';

use IsaiasCardenas\CorreosChile\Domcrawler;

$domCrawler = new Domcrawler('RT993112324DE');

var_dump($domCrawler->getData());
