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
                'content-type' => 'application/json',
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
        $this->httpMethod = "POST";
        $this->query = [
            "type" => $feature ?? "",
        ];
        $this->body = json_encode($payload);
        
        $this->endpoint = "/api/v1/startup/public/feature";

        return $this->send();
    }

    public function update($feature, $id, $payload) 
    {
        extract($payload);
        $this->setClient();
        $this->httpMethod = "PUT";
        $this->query = [
            "type" => $feature ?? "",
        ];
        $this->body = json_encode($payload);
        
        $this->endpoint = "/api/v1/startup/public/feature/" . $id;

        return $this->send();
    }


    public function delete($feature, $id) 
    {
        extract($payload);
        $this->setClient();
        $this->httpMethod = "DELETE";
        $this->query = [
            "type" => $feature ?? "",
        ];
        
        $this->endpoint = "/api/v1/startup/public/feature/" . $id;

        return $this->send();
    }

    private function send() 
    {
        
        $res = $this->client->request($this->httpMethod, $this->endpoint, [
            'query' => $this->query,
            'body' => $this->body,
        ]);
        if  ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return json_decode($res->getBody()->getContents()) ;
    }
}