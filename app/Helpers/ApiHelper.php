<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ApiHelper
{
    protected $client;
    protected $endpoint = '';
    protected $data = [];
    protected $type = '';

    /**
     * ApiHelper constructor.
     * @param $endpoint
     * @param array $data
     * @param string $type
     */
    public function __construct($endpoint, $data = [], $type = 'GET')
    {
        $this->client = curl_init();
        $this->endpoint = $endpoint;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
        curl_setopt_array($this->client, array(
            CURLOPT_URL => \Config::get('api.base') . $this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->type,
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($this->client);
        return json_decode($response);
    }
}