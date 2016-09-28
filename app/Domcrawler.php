<?php

namespace App;

use App\Request;
use Symfony\Component\DomCrawler\Crawler;

class Domcrawler
{
    private $html;
    private $crawler;

    public function __construct($trakingCode)
    {
        $request = new Request();
        $this->html = $request->getHttp($trakingCode);
    }

    public function arst()
    {
        echo $this->html;
    }
}
