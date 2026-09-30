<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\paymentGatewaysResource;
use App\Models\PaymentGateway;
use App\Repositories\PaymentGatewayRepository;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Request;

#[Group('Payment Gateways API')]
class PaymentGatewayController extends Controller
{

    /**
     * Get Payment Gateways
     *
     */
    public function index()
    {
        $paymentGateways = PaymentGatewayRepository::getAll()
            ->where('is_active', '1');

        return $this->json('Active payment gateways fetched successfully', [
            'paymentGateways' => paymentGatewaysResource::collection($paymentGateways),
        ]);
    }
}
