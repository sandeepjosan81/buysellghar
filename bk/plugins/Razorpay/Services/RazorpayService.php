<?php

namespace Plugins\Razorpay\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );
    }

    public function createOrder($amount)
    {
        $orderData = $this->api->order->create([
            'receipt' => 'order_rcptid_' . time(),
            'amount' => $amount * 100,
            'currency' => 'INR'
        ]); 
        // echo "<pre>ppp";
        // print_r($orderData);
        // echo "</pre>";
        // exit;
        return $orderData;
    }

    public function verifyPayment($data)
    {
        return $this->api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $data['razorpay_order_id'],
            'razorpay_payment_id' => $data['razorpay_payment_id'],
            'razorpay_signature' => $data['razorpay_signature']
        ]);
    }

    public function logFailure($data)
    {
        \Log::error('Razorpay Failed', $data);
    }
}