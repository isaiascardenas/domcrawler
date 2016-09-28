<?php

require 'vendor/autoload.php';

// use App\DomCrawler;

// $domCrawler = new DomCrawler('RT993112324DE');
// $domCrawler->arst();

use App\Request;
use Symfony\Component\DomCrawler\Crawler;

$request = new Request();
$html = $request->getHttp('RT993112324DE');

// $crawler = new Crawler($html);

// $crawler = $crawler->filter('#Panel_Entrega > table')->children();

// if (!is_null($crawler)) {
//     foreach ($crawler as $key => $node) {
//         $data = $node->nodeValue;
//         $data = explode('
//             ', $data);
//         var_dump($data);
//         echo "\n";
//     }
// }


// $crawler = $crawler->filter('#pnlEnvio > table')->children();

// foreach ($crawler as $key => $node) {
//     if ($key != 0) {
//         $data = $node->nodeValue;
//         $data = explode('
//             ', $data);
//         var_dump([
//             'status' => beautyString($data[0]),
//             'date' => beautyString($data[1]),
//             ]);
//         echo "\n";
//     }
// }

// ////////////////helper//////
// function beautyString($string)
// {
//     return trim(substr($string, 4, -3), ' ');
// }

echo $html;
