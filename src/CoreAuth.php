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
    private Array $query = [];
    private String $appKey;
    private String $appSecret;
    private String $endpoint;

    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
      

    }

    public function login($username, $password = null, $device = null, $fcm_token = null)
    {
        if (is_array($username)) {
            extract($username);
        }
        
        $this->body = json_encode([
            "username" => $username,
            "password" => $password,
            "device" => $device,
            "fcm_token" => $fcm_token,
        ]);
        $this->endpoint = "/api/v1/startup/public/auth/login";
        $this->setClient();
        return $this->send();
    }

    public function registration($payload)
    {
        extract($payload);
 
        $this->body = json_encode([
            "email" => $email,
            "password" => $password,
            "username" => $username,
            "phone" => $phone,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "gender" => $gender,
            "address" => $address,
            "province_id" => $province_id,
            "regency_id" => $regency_id,
            "district_id" => $district_id,
            "village_id" => $village_id,
        ]);
        $this->endpoint = "/api/v1/startup/public/auth/registration";
        $this->setClient();
        return $this->send();
    }

    public function validation($payload)
    {
        extract($payload);
 
        $this->body = json_encode([
            "email" => $email,
            "phone" => $phone,
            "otp_number" => $first_name,
           
        ]);
        $this->endpoint = "/api/v1/startup/public/auth/validation";
        $this->setClient();
        return $this->send();
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
                'content-type' => 'application/json',
                "APP-ID" => $this->appKey,
            ]
        ]);
    }


    private function send()
    {
        // dd($this->body);
        $res = $this->client->request($this->httpMethod, $this->endpoint, [
            'query' => $this->query,
            'body' => $this->body,
        ]);
        if ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return json_decode($res->getBody()->getContents());
    }
}
