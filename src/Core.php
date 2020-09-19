<?php
namespace Ametsuramet\StartupEngine;
use JsonMapper;
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
}