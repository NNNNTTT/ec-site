<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class StripeService
{
    private string $secret_key;

    // 初期化時にストライプのシークレットキーを設定
    public function __construct() {
        $this->secret_key = config('services.stripe.secret_key');
        \Stripe\Stripe::setApiKey($this->secret_key);
    }

    public function createClientSecret(): array {   
        try{
            $setupIntent = \Stripe\SetupIntent::create([
                'payment_method_types' => ['card'],
            ]);

            return [
                'success' => true,
                'client_secret' => $setupIntent->client_secret,
            ];

        }catch(\Exception $e){
            Log::error('セットアップインテントの作成に失敗しました: ' . $e->getMessage());            

            return [
                'success' => false,
                'error' => 'クレジットカード決済が利用できない状態です。サーバー管理者にお知らせください。',
            ];
        }
    }

    public function createCustomer(string $setup_intent_id): array {
        try{
            $setup_intent = \Stripe\SetupIntent::retrieve($setup_intent_id);
            $payment_method_id = $setup_intent->payment_method;
            $customer = \Stripe\Customer::create([
                'payment_method' => $payment_method_id,
            ]);

            return [
                'success' => true,
                'customer_id' => $customer->id,
                'payment_method_id' => $payment_method_id,
            ];

        }catch(\Exception $e){
            Log::error('顧客の作成に失敗しました: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => 'クレジットカード決済が利用できない状態です。サーバー管理者にお知らせください。',
            ];
        }
    }

    public function yoshin($order): array{
        try{
            $payment_intent = \Stripe\PaymentIntent::create([
                'amount' => $order->total_price,
                'currency' => 'jpy',
                'customer' => $order->customer_id,
                'payment_method' => $order->payment_method_id,
                'confirm' => true,
                'off_session' => true,
                "capture_method" => "manual",     
            ]);
    
            return [
                'success' => true,
                'stripe_pi_id' => $payment_intent->id,
                'stripe_customer_id' => $order->customer_id,
                'stripe_payment_method_id' => $order->payment_method_id,
                'yoshin_status' => $payment_intent->status,
                'stripe_yoshin' => now(),
            ];

        }catch(\Exception $e){
            Log::error('決済(与信)に失敗しました: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => 'クレジットカードエラー',
            ];
        }

    }

    public function capture($order): array{
        try{
            $payment_intent = \Stripe\PaymentIntent::retrieve($order->stripe_pi_id);
            $payment_intent->capture();
    
            return [
                'success' => false,
                'error' => '決済(確定)に失敗',
            ];

        }catch(\Exception $e){
            Log::error('決済(確定)に失敗しました: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => '決済(確定)に失敗',
            ];
        }

    }

    public function cancel($order): array{
        try{
        $payment_intent = \Stripe\PaymentIntent::retrieve($order->stripe_pi_id);
        $payment_intent->cancel();

        return [
                'success' => true,
            ];

        }catch(\Exception $e){
            Log::error('決済(キャンセル)に失敗しました: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => '決済(キャンセル)に失敗',
            ];
        }
    }

    
}