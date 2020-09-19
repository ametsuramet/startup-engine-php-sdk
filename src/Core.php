<?php
namespace Ametsuramet\StartupEngine;
class Core {
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
    private array $collection;
    private $data;

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
}