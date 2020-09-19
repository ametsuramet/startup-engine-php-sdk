<?php

namespace Ametsuramet\StartupEngine;

use GuzzleHttp;

class CoreModule extends Core
{

    

    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
    public function setToken($token)
    {
        $this->token = $token;
    }

    private function setClient()
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


    

    public function getList($feature, $payload, $filter = [])
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

        if ($filter)
            $this->query['filter'] = json_encode($filter);

        $this->endpoint = "/api/v1/startup/public/feature";
        $response = $this->send();

        $this->collection = $response->data;
        return $response;
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

        $response = $this->send();
        $this->data = $response->data;
        return $response;
    }

    public function show($feature, $id)
    {
        $this->setClient();
        $this->httpMethod = "GET";
        $this->query = [
            "type" => $feature ?? "",
        ];

        $this->endpoint = "/api/v1/startup/public/feature/" . $id;
        $response = $this->send();
        $this->data = $response->data;
        return $response;
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
        $response = $this->send();
        $this->data = $response->data;
        return $response;
    }


    public function delete($feature, $id)
    {
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
        if ($res->getStatusCode() != 200) {
            throw new \Exception("Error Request => " . $res->getStatusCode());
        }
        return json_decode($res->getBody()->getContents());
    }

}
