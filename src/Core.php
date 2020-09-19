<?php
namespace Ametsuramet\StartupEngine;
use JsonMapper;
use GuzzleHttp;

class Core {
    protected String $baseUrl = "http://localhost:9000";
    protected String $appKey;
    protected String $appSecret;
    protected String $feature;
    protected $client;
    protected $httpMethod = "GET";
    protected $query;
    protected $endpoint;
    protected $token;
    protected String $body = "";
    protected array $collection;
    protected $data;

    public function toCollection($class)
    {
        $data = [];
        foreach ($this->collection as $key => $d) {
            $mapper = new JsonMapper();
            $data[] = $mapper->map($d, new $class);
        }

        return $data;
    }

    protected function toObject($class)
    {
        $mapper = new JsonMapper();
        return $mapper->map($this->data, new $class);
    }
    
    protected function toJson()
    {
        return json_encode($this->data);
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
    public function setToken($token)
    {
        $this->token = $token;
    }

    protected function setClient()
    {
        $this->client =  new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                "APP-ID" => $this->appKey,
                'content-type' => 'application/json',
                "Authorization" => "Bearer " . $this->token,
            ]
        ]);
    }

    protected function send()
    {

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