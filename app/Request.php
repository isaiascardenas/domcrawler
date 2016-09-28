<?php

namespace App;

use GuzzleHttp\Client;

class Request
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getHttp($trackingNumber)
    {
        return $this->get('http://seguimientoweb.correos.cl/ConEnvCorreos.aspx', $trackingNumber)
            ->getBody()
            ->getContents();
    }

    private function get($url, $trackingNumber)
    {
        return $this->client->request('POST', $url, [
            'form_params' => [
                'obj_key' => 'Cor398-cc',
                'obj_env' => $trackingNumber,
                ]
            ]);
    }
}
