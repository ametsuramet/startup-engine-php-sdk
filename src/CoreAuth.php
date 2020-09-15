<?php

namespace Ametsuramet\StartupEngine;

use GuzzleHttp;


class CoreAuth
{
    private String $baseUrl = "http://localhost:9000";
    private String $username;
    private String $password;
    private String $device;
    private String $fcm_token;
    private String $httpMethod = "POST";
    private String $body;
    private String $appKey;
    private String $appSecret;

    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
      

    }

    public function login($username, $password, $device, $fcm_token)
    {
        $this->username = $username;
        $this->password = $password;
        $this->device = $device;
        $this->fcm_token = $fcm_token;
        $this->body = json_encode([
            "username" => $username,
            "password" => $password,
            "device" => $device,
            "fcm_token" => $fcm_token,
        ]);
        $this->setClient();
        $this->send();
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    private function setClient()
    {
        $this->client =  new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                "APP-ID" => $this->appKey,
            ]
        ]);
    }


    private function send()
    {
        $res = $this->client->request($this->httpMethod, $this->endpoint, [
            'query' => $this->query,
            'body' => $this->body,
        ]);
        if ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return json_decode($res->getBody()->getContents(), true);
    }
}
