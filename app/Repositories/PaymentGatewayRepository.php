<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\PaymentGateway;

class PaymentGatewayRepository extends Repository
{
    public static function model()
    {
        return PaymentGateway::class;    
    }
}