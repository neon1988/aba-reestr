<?php

namespace App\Services;

use YooKassa\Client;

class YooKassaService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(config('yookassa.shop_id'), config('yookassa.secret_key'));
    }

    public function createPayment($amount, $description, $returnUrl)
    {
        return $this->client->createPayment([
            'amount' => [
                'value' => number_format($amount, 2, '.', ''),
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $returnUrl,
            ],
            'capture' => true,
            'description' => $description,
        ], uniqid('', true));
    }
}
