<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationFactory;

class YooKassaService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(config('yookassa.shop_id'), config('yookassa.secret_key'));
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function createPayment($amount, $returnUrl, $description, $metadata = [], $idempotenceKey = null)
    {
        if (empty($idempotenceKey))
            $idempotenceKey = uniqid('', true);

        try {
            $response = $this->client->createPayment([
                'amount' => [
                    'value' => number_format($amount, 2, '.', ''),
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $returnUrl
                ],
                'capture' => true,
                'description' => $description,
                'metadata' => $metadata,
            ], $idempotenceKey);

            return $response;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getPaymentInfo(string $paymentId)
    {
        try {
            $response = $this->client->getPaymentInfo($paymentId);
        } catch (\Exception $e) {
            $response = $e;
            return false;
        }

        return $response;
    }

    public function cancelPayment(string $paymentId, $idempotenceKey = null)
    {
        return $this->client->cancelPayment($paymentId, $idempotenceKey);
    }

    public function parseWebhook(Request $request)
    {
        $source = $request->getContent();
        $data = json_decode($source, true);

        $factory = new NotificationFactory();
        return $factory->factory($data);
    }

    public function getNewIdempotenceKey(): string
    {
        return Str::uuid();
    }
}
