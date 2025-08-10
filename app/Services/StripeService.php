<?php

namespace App\Services;

class StripeService
{
    public function createClientSecret()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $setupIntent = \Stripe\SetupIntent::create([
            'payment_method_types' => ['card'],
        ]);

        $client_secret = $setupIntent->client_secret;

        return $client_secret;

    }

    public function createCustomer($setup_intent_id){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $setup_intent = \Stripe\SetupIntent::retrieve($setup_intent_id);
        $payment_method_id = $setup_intent->payment_method;
        $customer = \Stripe\Customer::create([
            'payment_method' => $payment_method_id,
        ]);
        $customer_id = $customer->id;

        return [$customer_id, $payment_method_id];
    }

    public function yoshin($order){
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $order->total_price,
            'currency' => 'jpy',
            'customer' => $order->customer_id,
            'payment_method' => $order->payment_method_id,
            'confirm' => true,
            'off_session' => true,
            "capture_method" => "manual",     
        ]);

        $yoshin_data = [
            'stripe_pi_id' => $payment_intent->id,
            'stripe_customer_id' => $order->customer_id,
            'stripe_payment_method_id' => $order->payment_method_id,
            'yoshin_status' => $payment_intent->status,
            'stripe_yoshin' => now(),
        ];

        return $yoshin_data;
    }
}