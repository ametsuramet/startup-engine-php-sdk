<?php
namespace Ametsuramet\StartupEngine;
use GuzzleHttp;

class CoreModule {
    private String $baseUrl = "http://localhost:9000/api/v1";
    private String $appKey;
    private String $appSecret;
    private String $feature;
    private $client;
    private $httpMethod = "GET";
    private $query;
    private $endpoint;

    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->client =  new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                "APP-ID" => $appKey,
            ]
        ]);

    }

    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function getList($feature,  $search = "", $page = 1, $limit = 20) 
    {
        $this->httpMethod = "GET";
        $this->query = [
            "type" => $feature,
            "search" => $search,
            "page" => $page,
            "limit" => $limit,
        ];
        
        $this->endpoint = "/public/feature";

        return $this->send();
    }

    private function send() 
    {
        $res = $this->client->request($this->httpMethod, $this->endpoint, [
            'query' => $this->query,
        ]);
        if  ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return $res->getBody();
    }
}