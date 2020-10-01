<?php

namespace Ametsuramet\StartupEngine;

use GuzzleHttp;

class CoreAuth extends Core
{
    function __construct($appKey, $appSecret = "")
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
    }

    public function loginAdmin($username, $password = null, $device = null, $fcm_token = null)
    {
        $this->httpMethod = "POST";
        if (is_array($username)) {
            extract($username);
        }

        $this->body = json_encode([
            "username" => $username,
            "password" => $password,
            "device" => $device,
            "fcm_token" => $fcm_token,
        ]);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/user-admin/login";
        $this->setClient();
        return $this->send();
    }

    public function login($username, $password = null, $device = null, $fcm_token = null)
    {
        $this->httpMethod = "POST";
        if (is_array($username)) {
            extract($username);
        }

        $this->body = json_encode([
            "username" => $username,
            "password" => $password,
            "device" => $device,
            "fcm_token" => $fcm_token,
        ]);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/auth/login";
        $this->setClient();
        return $this->send();
    }

    public function registration($payload)
    {
        $this->httpMethod = "POST";
        extract($payload);

        $this->body = json_encode([
            "email" => $email ?? null,
            "password" => $password ?? null,
            "username" => $username ?? null,
            "phone" => $phone ?? null,
            "first_name" => $first_name ?? null,
            "middle_name" => $middle_name ?? null,
            "last_name" => $last_name ?? null,
            "gender" => $gender ?? null,
            "address" => $address ?? null,
            "province_id" => $province_id ?? null,
            "regency_id" => $regency_id ?? null,
            "district_id" => $district_id ?? null,
            "village_id" => $village_id ?? null,
        ]);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/auth/registration";
        $this->setClient();
        return $this->send();
    }

    public function validation($payload)
    {
        $this->httpMethod = "POST";
        extract($payload);

        $this->body = json_encode([
            "email" => $email,
            "phone" => $phone,
            "otp_number" => $otp_number,

        ]);
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/auth/validation";
        $this->setClient();
        return $this->send();
    }


    public function profile()
    {
        $this->httpMethod = "GET";

        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/profile";
        $this->setClient();
        return $this->send();
    }

    public function upload($multipart)
    {
        $this->httpMethod = "POST";
        $this->client =  new GuzzleHttp\Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                "APP-ID" => $this->appKey,
                "APP-SECRET" => $this->appSecret,
                "Authorization" => "Bearer " . $this->token,
            ]
        ]);
        $this->multipart = $multipart;
        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/upload";
        return $this->send();
    }

    public function updateProfile($payload)
    {
        $this->httpMethod = "PUT";
        extract($payload);

        $this->body = json_encode([
            "phone" => $phone ?? null,
            "first_name" => $first_name ?? null,
            "middle_name" => $middle_name ?? null,
            "last_name" => $last_name ?? null,
            "gender" => $gender ?? null,
            "address" => $address ?? null,
            "province_id" => $province_id ?? null,
            "regency_id" => $regency_id ?? null,
            "district_id" => $district_id ?? null,
            "village_id" => $village_id ?? null,
            "path" => $path ?? null,
            "mime_type" => $mime_type ?? null,
        ]);

        if (!$this->endpoint)
            $this->endpoint = "/api/v1/startup/public/profile";
        $this->setClient();
        return $this->send();
    }
}
