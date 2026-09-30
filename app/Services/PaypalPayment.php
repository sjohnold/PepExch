<?php

namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;
use PaypalServerSdkLib\PaypalServerSdkClientBuilder;
use PaypalServerSdkLib\Authentication\ClientCredentialsAuthCredentialsBuilder;
use PaypalServerSdkLib\Orders\OrdersCreateRequest;
use PaypalServerSdkLib\Environment;

class PaypalPayment implements PaymentGatewayInterface
{
    public function processPayment($amount, array $data, array $config)
    {
        $environment = ($config['mode'] ?? 'sandbox') === 'live'
            ? Environment::PRODUCTION
            : Environment::SANDBOX;

        $client = PaypalServerSdkClientBuilder::init()
            ->clientCredentialsAuthCredentials(
                ClientCredentialsAuthCredentialsBuilder::init(
                    $config['client_id'] ?? '',
                    $config['client_secret'] ?? ''
                )
            )
            ->environment($environment)
            ->build();

        $order = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $config['currency'] ?? 'USD',
                    'value' => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => route('paypal.payment.success', $data['identifier']),
                'cancel_url' => route('paypal.payment.cancel'),
            ],
        ];

        try {
            $response = $client->getOrdersController()->createOrder(['body' => $order]);

            $orderModel = $response->getResult();

            $orderAsArray = json_decode(json_encode($orderModel), true);

            // Now $orderAsArray is a clean nested PHP array

            foreach ($orderAsArray['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href'])->send();
                }
            }

            return response()->json(['message' => 'Approval link not found'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
