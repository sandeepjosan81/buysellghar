<?php

namespace Plugins\Razorpay\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Plugins\Razorpay\Services\RazorpayService;
use InnoShop\Common\Services\StateMachineService;
use InnoShop\Common\Models\Order;
use InnoShop\Common\Models\Order\Payment;
use InnoShop\Common\Repositories\Order\PaymentRepo;

class RazorpayPaymentController extends Controller
{
    protected $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    public function index()
    {
        
        //$order = Order::find(2); 
      
        // $this->razorpay->verifyPayment($request->all());
        // Update order status to paid
        // StateMachineService::getInstance($order)->changeStatus(StateMachineService::PAID, '', true);
        //StateMachineService::getInstance($order)->changeStatus(StateMachineService::FAILED, '', true);
        
        return view('razorpay::payment');
    }

    // Demo purpose, you can remove this method and directly call createOrder in your checkout process
    // public function pay(Request $request)
    // {
    //     $order = $this->razorpay->createOrder($request->amount);

    //     return view('razorpay::payment', [
    //         'order_id' => $order['id'],
    //         'amount' => $request->amount
    //     ]);
    // }

    public function success(Request $request)
    {
       
        try {
            
            // $req = $request->all(); 
            // $order = Order::find(@$req['order_id']);

            $order = Order::query()->where('number', $request->number)->firstOrFail();                   
            // Update order status to paid

            if($order->status != 'unpaid') {
                throw new \Exception("Order status must be unpaid, now is {$order->status}!");
            }else if($order->status == 'paid'){
                return redirect("/");
            }

            StateMachineService::getInstance($order)->changeStatus(StateMachineService::PAID, '', true);
            // $paymentData = [ 'paid' => true];
            // PaymentRepo::getInstance()->createOrUpdatePayment($order->id, $paymentData);
            $orderPayment = Payment::query()->where('order_id', $order->id)->first();


            return view('razorpay::success', [
                'number' => $request->number ?? 'N/A',
                'amount' => $order->total ?? '0.00',
                'gateway_payment_id' => $orderPayment->gateway_payment_id ?? 'N/A',
            ]);
        } catch (\Exception $e) {
            return "error: " . $e->getMessage();
        }
    }

    public function failed(Request $request)
    {
        // You can log error here
        $req = $request->all();
        $req['number'] = $request->number ?? 'N/A';
        // $this->razorpay->logFailure($request->all());
        // $order = Order::find(@$req['order_id']); 
        // Update order status to paid
        $order = Order::query()->where('number', $request->number)->firstOrFail();
        
        \Log::error('Razorpay Payment Failed', $request->all());
        return view('razorpay::failed', [
            'error' => $request->error ?? 'Payment Failed',
            'number' => $req['number']?? 'N/A',
            'amount' => $order->total ?? '0.00',
        ]);
    }


    public function update_order_payment(Request $request){
       
        try {
            
            $data = $request->all();
            $order_id = $data['order_id'] ?? null;
            // echo "<pre> Data"; print_r($data); echo "</pre>";  // Debugging line to check incoming data
            // echo "<pre> response"; print_r($data['response']); echo "</pre>";  // Debugging line to check response data
            $orderPayment = Payment::query()->where('order_id', $order_id)->first();

            // VeryFy Razorpay payment signature to ensure authenticity
            $veryFyResult = [
                'razorpay_order_id' => $data['response']['razorpay_order_id'],
                'razorpay_payment_id' => $data['response']['razorpay_payment_id'],
                'razorpay_signature' => $data['response']['razorpay_signature']
            ];
            $responseSignature = $this->razorpay->verifyPayment($veryFyResult);
            // echo "<pre> verify result"; print_r($responseSignature); echo "</pre>";  // Debugging line to check verification result
            // exit;
            // if($responseSignature=="verify result"){
                $orderPayment->gateway_payment_id = $data['response']['razorpay_payment_id'] ?? null;
                $orderPayment->reference = $data['response'] ?? null;
                $orderPayment->paid = true;
                $orderPayment->save();
            // }
            
        } catch (\Exception $e) {
            \Log::error('Failed to update order payment: ' . $e->getMessage(), $request->all());
            return json_fail('Failed to update order payment: ' . $e->getMessage());
        }

        return true;
    }
}