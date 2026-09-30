<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Use delete() instead of truncate() to avoid FK constraint error
        PaymentGateway::query()->delete();

        $gateways = [
            'stripe' => [
                'publishable_key' => 'pk_test_51OU2r2KdjtJ0K09AnX8tNZGPSpTzJjd9hbWZ6iOwRru2LMbRSpdZJ8XWic5CPl2ps5wnGx7Wspr1pNMsUL7JadKg00MnWTpw12',
                'secret_key' => 'sk_test_51OU2r2KdjtJ0K09AajdztowtylB7pAXRdqsi2aFHNXqO1HEaR7a33YUZiHAOFTT1zoXDP9cca33JYCY7Q8K0bUSW00fd1XVpj4',
            ],
            'aamarpay' => [
                'store_id' => 'aamarpaytest',
                'signature_key' => 'dbb74894e82415a2f7ff0ec3a97e4183',
                'currency' => 'BDT',
            ],
            'paypal' => [
                'mode' => 'sandbox',
                'app_id' => 'APP-80W284485P519543T',
                'client_id' => 'AdIm__wXnoq3THz55M5mgEWWyNZVQHF1mNWtrJPz5togtRLfZbfExq7fcPyxzGGk9-9IC1d_lLZYRO2H',
                'client_secret' => 'EH-ZMtMC7Kn7RNxEHURHFAxud2Z2iyR20TQsAzUGrhPoeOlvb4HZj4UEQRvMTl8uMlnnnGy--Rvo5PKs',
                'business_email' => 'sb-d0dtp29979354@personal.example.com',
            ],

        ];

        // Media mapping
        $mediaMapping = [
            'stripe' => 'stripe.svg',
            'aamarpay' => 'amarpay.png',
            'paypal' => 'paypal.svg',
        ];

        foreach ($gateways as $name => $config) {
            $paymentGateway = PaymentGateway::updateOrCreate(
                ['name' => $name],
                [
                    'config' => json_encode($config),
                    'type' => 'test',
                    'is_active' => true,
                ]
            );

            if (isset($mediaMapping[$name])) {
                $media = Media::factory()->create([
                    'type' => 'image',
                    'src' => "assets/img/payment/{$mediaMapping[$name]}",
                    'extension' => pathinfo($mediaMapping[$name], PATHINFO_EXTENSION),
                ]);

                $paymentGateway->update(['media_id' => $media->id]);
            }
        }
    }
}
