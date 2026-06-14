<?php

namespace Plugins\Razorpay\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;


class PaymentController extends Controller
{
    public function index()
    {
        return view('razorpay::payment');
    }

    public function pay(Request $request)
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        $order = $api->order->create([
            'receipt' => 'order_rcptid_11',
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ]);

        return view('razorpay::payment', [
            'order_id' => $order['id'],
            'amount' => $request->amount
        ]);
    }

    public function success(Request $request)
    {
        $api = new Api(config('razorpay.key'), config('razorpay.secret'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            return "Payment Successful";
        } catch (\Exception $e) {
            return "Payment Failed";
        }
    }
}