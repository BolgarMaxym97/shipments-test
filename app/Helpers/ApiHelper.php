<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ApiHelper
{
    protected $client;
    protected $endpoint = '';
    protected $data = [];
    protected $type = '';
    protected $url;

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
        $this->url = \Config::get('api.base') . $this->endpoint . '?token=' . \Session::get('auth_token');
        $this->setSettings();
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
        $response = curl_exec($this->client);
        return json_decode($response);
    }

    /**
     *  Only POST and GET requests
     */
    private function setSettings()
    {
        curl_setopt_array($this->client, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->type,
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        if (mb_strtoupper($this->type) == 'GET') {
            $this->get();
        } else {
            $this->other();
        }
    }

    private function other()
    {
        curl_setopt_array($this->client, array(
            CURLOPT_URL => $this->url,
            CURLOPT_POSTFIELDS => json_encode($this->data),
        ));
    }

    private function get()
    {
        curl_setopt($this->client, CURLOPT_URL, $this->url . '&' . http_build_query($this->data));
    }
}