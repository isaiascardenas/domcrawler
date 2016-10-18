<?php

require 'vendor/autoload.php';

use IsaiasCardenas\CorreosChile\Request;
use Symfony\Component\DomCrawler\Crawler;

/////////////////////

$trackingCode = 'RE127140035DE';
$request = new Request();
    //
$html = $request->getHtml($trackingCode);
echo $html;

/////// TEST //////
//RS625984015NL
 
//RK497366997CN

//RK479982652CN

//RT993112324DE

//RE127140035DE
