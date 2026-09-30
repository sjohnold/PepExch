<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Repositories\PaymentGatewayRepository;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{

    public function index()
    {

        $paymentGateways = PaymentGatewayRepository::getAll();
        $paypal = $paymentGateways->firstWhere('name', 'paypal');
        return view('admin.payment_gateways.index', compact('paymentGateways', 'paypal'));
    }

    public function edit($id)
    {
        $paypal = PaymentGateway::findOrFail($id);
        $paypalConfig = json_decode($paypal->config, true); // true = associative array

        return view('admin.payment_gateways.edit', compact('paypal', 'paypalConfig'));
    }

    public function update(Request $request, $id)
    {
        $gateway = PaymentGateway::findOrFail($id);

        // Ensure config is an array
        $config = is_array($gateway->config) ? $gateway->config : json_decode($gateway->config, true);

        // Validate fields dynamically based on gateway type
        $rules = [];
        if ($gateway->name === 'paypal') {
            $rules = [
                'mode' => 'required|in:sandbox,live',
                'app_id' => 'required|string',
                'client_id' => 'required|string',
                'client_secret' => 'required|string',
            ];
        } elseif ($gateway->name === 'stripe') {
            $rules = [
                'publishable_key' => 'required|string',
                'secret_key' => 'required|string',
            ];
        } elseif ($gateway->name === 'aamarpay') {
            $rules = [
                'store_id' => 'required|string',
                'signature_key' => 'required|string',
                'currency' => 'required|string',
            ];
        }

        $validated = $request->validate($rules);

        // Update the config array safely
        foreach ($validated as $key => $value) {
            $config[$key] = $value;
        }

        $gateway->update([
            'config' => $config,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', ucfirst($gateway->name) . ' updated successfully.');
    }
}
