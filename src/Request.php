<?php

namespace IsaiasCardenas\CorreosChile;

use GuzzleHttp\Client;

class Request
{
    private $client;
    const URL_TRACKING = 'http://seguimientoweb.correos.cl/ConEnvCorreos.aspx';
    const TOKEN = 'Cor398-cc';
    
    public function __construct()
    {
        $this->client = new Client();
    }

    public function getHtml($trackingNumber)
    {
        return $this->get(self::URL_TRACKING, $trackingNumber)
            ->getBody()
            ->getContents();
    }

    private function get($url, $trackingNumber)
    {
        return $this->client->request('POST', $url, [
            'form_params' => [
                'obj_key' => self::TOKEN,
                'obj_env' => $trackingNumber,
                ]
            ]);
    }
}
