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
        $this->setClient();
        $this->query = [
            "limit" => $limit ?? 1000,
        ];
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/master/province";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }

    public function getRegency($filter = [])
    {
        $this->setClient();
        $this->query = [
            "limit" => $limit ?? 1000,
        ];
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/master/regency";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }

    public function getDistrict($filter = [])
    {
        $this->setClient();
        $this->query = [
            "limit" => $limit ?? 1000,
        ];
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/master/district";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }

    public function getVillage($filter = [])
    {
        $this->setClient();
        $this->query = [
            "limit" => $limit ?? 1000,
        ];
        if ($filter)
            $this->query['filter'] = json_encode($filter);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/master/village";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
    }
}
