<?php

namespace Ametsuramet\StartupEngine;

use GuzzleHttp;

class CoreMaster extends Core
{
    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function getProvince()
    {
        
        $this->endpoint = "/api/v1/startup/public/master/province";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }
    public function getRegency($filter = [])
    {
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        $this->endpoint = "/api/v1/startup/public/master/regency";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }
    public function getDistrict($filter = [])
    {
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        $this->endpoint = "/api/v1/startup/public/master/district";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }
    public function getVillage($filter = [])
    {
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        $this->endpoint = "/api/v1/startup/public/master/village";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }
}