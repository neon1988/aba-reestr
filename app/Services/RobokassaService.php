<?php

namespace App\Services;

use Exception;
use Robokassa\Robokassa;

class RobokassaService
{
    protected Robokassa $robokassa;
    private string $login;
    private string $password1;
    private string $password2;
    private $hashType = 'md5';

    private array $validIps = ['185.59.216.65', '185.59.217.65'];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $params = [
            'login' => config('robokassa.login'),
            'password1' => config('robokassa.password1'),
            'password2' => config('robokassa.password2'),
            'hashType' => config('robokassa.hashType'),
            'is_test' => config('robokassa.is_test') ? 1 : 0,
            'test_password1' => config('robokassa.password1'),
            'test_password2' => config('robokassa.password2'),
        ];
        $this->login = $params['login'];
        $this->password1 = $params['password1'];
        $this->password2 = $params['password2'];

        $this->robokassa = new Robokassa($params);
    }

    /**
     * @throws Exception
     */
    public function createPayment(float $amount, string $invoiceID, string $description, array $receipt = []): string
    {
        $params = [
            'OutSum' => $amount,
            'InvoiceID' => $invoiceID,
            'Description' => $description,
            'Receipt' => $receipt
        ];

        return $this->robokassa->sendPaymentRequestCurl($params);
    }

    /**
     * @throws Exception
     */
    public function getPaymentMethods(): array
    {
        return $this->robokassa->getPaymentMethods();
    }

    /**
     *
     * @throws Exception
     */
    public function checkPaymentStatus(string $invoiceID): array
    {
        /*
         * не оплаченный платеж
         $data = [
                "Result" => [
                    "Code" => 0
                ],
                "State" => [
                    "Code" => 5,
                    "RequestDate" => "2025-03-21T13:17:51.5631953+03:00",
                    "StateDate" => "2025-03-21T13:01:08.3233333+03:00"
                ],
                "Info" => [
                    "IncCurrLabel" => "SBPPSR",
                    "IncSum" => 1,
                    "IncAccount" => "000000******0000",
                    "PaymentMethod" => [
                        "Code" => "PayButton"
                    ],
                    "OutCurrLabel" => "BNR",
                    "OutSum" => 1
                ],
                "UserFields" => []
            ];
         * оплаченный платеж
        $data = [
    "Result" => [
        "Code" => 0
    ],
    "State" => [
        "Code" => 100,
        "RequestDate" => "2025-03-21T13:34:54.8998262+03:00",
        "StateDate" => "2025-03-21T13:31:22.1033333+03:00"
    ],
    "Info" => [
        "IncCurrLabel" => "SBPPSR",
        "IncSum" => 1,
        "IncAccount" => "000000******0000",
        "PaymentMethod" => [
            "Code" => "PayButton"
        ],
        "OutCurrLabel" => "BNR",
        "OutSum" => 1
    ],
    "UserFields" => []
];
         */
        return $this->robokassa->opState($invoiceID);
    }

    /**
     * Проверяет корректность подписи от Robokassa для успешного платежа (SuccessURL).
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function isValidSuccessSignature(array $data): bool
    {
        if (!isset($data['OutSum'], $data['InvId'], $data['SignatureValue'])) {
            throw new Exception('Отсутствуют обязательные параметры');
        }

        $outSum = $data['OutSum'];
        $invId = $data['InvId'];
        $crc = strtoupper($data['SignatureValue']);

        // Извлекаем пользовательские параметры (Shp_*)
        $shpParams = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'Shp_')) {
                $shpParams[$key] = $value;
            }
        }

        // Сортируем параметры по ключу (важно для корректного хэша)
        ksort($shpParams);

        // Формируем строку с параметрами в нужном формате
        $baseString = "$outSum:$invId:{$this->getPassword1()}";
        foreach ($shpParams as $key => $value) {
            $baseString .= ":$key=$value";
        }

        $myCrc = strtoupper(hash($this->getHashType(), $baseString));

        return $myCrc === $crc;
    }

    /**
     * Проверяет подпись от Robokassa для ResultURL.
     *
     * @param array $data
     * @return bool
     */
    public function isValidResultSignature(array $data): bool
    {
        if (!isset($data['OutSum'], $data['InvId'], $data['SignatureValue'])) {
            throw new Exception('Отсутствуют обязательные параметры');
        }

        $outSum = $data['OutSum'];
        $invId = $data['InvId'];
        $crc = strtoupper($data['SignatureValue']);

        // Извлекаем пользовательские параметры (Shp_*)
        $shpParams = [];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'Shp_')) {
                $shpParams[$key] = $value;
            }
        }

        // Сортируем параметры по ключу (важно для корректного хэша)
        ksort($shpParams);

        // Формируем строку с параметрами в нужном формате
        $baseString = "$outSum:$invId:{$this->password2}";
        foreach ($shpParams as $key => $value) {
            $baseString .= ":$key=$value";
        }

        // Вычисляем контрольную сумму
        $myCrc = strtoupper(hash($this->getHashType(), $baseString));

        return $myCrc === $crc;
    }

    public function isValidIP(string $ip) :bool
    {
        $ip = trim($ip);
        return in_array($ip, $this->validIps);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword1(): string
    {
        return $this->password1;
    }

    /**
     * @return string
     */
    public function getPassword2(): string
    {
        return $this->password2;
    }

    /**
     * @return string
     */
    public function getHashType(): string
    {
        return $this->hashType;
    }
}
