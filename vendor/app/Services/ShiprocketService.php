<?php

namespace App\Services;

use GuzzleHttp\Client;

class ShiprocketService
{
    protected $client;
    protected $api_url = 'https://apiv2.shiprocket.in/v1/external/';
    protected $api_key;
    protected $api_secret;

    public function __construct()
    {
        $this->client = new Client();
        $this->api_key = env('SHIPROCKET_API_KEY');
        $this->api_secret = env('SHIPROCKET_API_SECRET');
    }

    public function getToken()
    {
        $response = $this->client->post($this->api_url . 'auth/login', [
            'json' => [
                'email' => env('SHIPROCKET_EMAIL'),
                'password' => env('SHIPROCKET_PASSWORD')
            ]
        ]);
        
        $body = json_decode($response->getBody());
        return $body->token;
    }

    public function createOrder($orderData)
    {
        $token = $this->getToken();

        $response = $this->client->post($this->api_url . 'orders/create/adhoc', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ],
            'json' => $orderData
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getOrderStatus($orderId)
    {
        $token = $this->getToken();

        $response = $this->client->get($this->api_url . "orders/status/{$orderId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
