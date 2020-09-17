<?php
namespace Ametsuramet\StartupEngine;
use GuzzleHttp;


class CoreModule {
    private String $baseUrl = "http://localhost:9000";
    private String $appKey;
    private String $appSecret;
    private String $feature;
    private $client;
    private $httpMethod = "GET";
    private $query;
    private $endpoint;
    private $token;
    private String $body = "";

    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
      

    }

    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }
    public function setToken($token) {
        $this->token = $token;
    }

    private function setClient() {
        $this->client =  new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                "APP-ID" => $this->appKey,
                "Authorization" => "Bearer ". $this->token,
            ]
        ]);
    }

 

    public function getList($feature, $payload) 
    {
        extract($payload);
        $this->setClient();
        $this->httpMethod = "GET";
        $this->query = [
            "type" => $feature ?? "",
            "search" => $search ?? "",
            "page" => $page ?? 1,
            "limit" => $limit ?? 20,
            "orderBy" => $orderBy ?? "",
            "order" => $order ?? "asc",
        ];
        
        $this->endpoint = "/api/v1/startup/public/feature";

        return $this->send();
    }
    public function create($feature, $payload) 
    {
        extract($payload);
        $this->setClient();
        $this->httpMethod = "GET";
        $this->query = [
            "type" => $feature ?? "",
        ];
        $this->body = json_encode($payload);
        
        $this->endpoint = "/api/v1/startup/public/feature";

        return $this->send();
    }

    private function send() 
    {
        $data = [
            'query' => $this->query,
        ];
        if ($this->body) {
            $data["body"] = $this->body;
        }
        $res = $this->client->request($this->httpMethod, $this->endpoint, $data);
        if  ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return json_decode($res->getBody()->getContents()) ;
    }
}