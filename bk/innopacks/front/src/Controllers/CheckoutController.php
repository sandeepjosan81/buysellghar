<?php


namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use InnoShop\Common\Exceptions\Unauthorized;
use InnoShop\Common\Services\CheckoutService;
use InnoShop\Common\Services\StateMachineService;
use InnoShop\Front\Requests\CheckoutConfirmRequest;
use Throwable;
use Plugins\Razorpay\Services\RazorpayService;
use InnoShop\Common\Repositories\Order\PaymentRepo;

class CheckoutController extends Controller
{


    //protected $razorpay;

    // public function __construct(RazorpayService $razorpay)
    // {
    //     $this->razorpay = $razorpay;
    // }
    
    /**
     * Get checkout data and render page.
     *
     * @return mixed
     * @throws Throwable
     */
    public function index(): mixed
    {
        try {
            $checkout = CheckoutService::getInstance();
            $result   = $checkout->getCheckoutResult();
            if (empty($result['cart_list'])) {
                return redirect(front_route('carts.index'))->withErrors(['error' => 'Empty Cart']);
            }

            return inno_view('checkout.index', $result);
        } catch (Unauthorized $e) {
            return redirect(front_route('login.index'))->withErrors(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            return redirect(front_route('carts.index'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update checkout, include shipping address, shipping method, billing address, billing method
     *
     * @param  Request  $request
     * @return mixed
     * @throws Throwable
     */
    public function update(Request $request): mixed
    {
        $data     = $request->all();
        $checkout = CheckoutService::getInstance();
        $checkout->updateValues($data);
        $result = $checkout->getCheckoutResult();

        return json_success('Update successful', $result);
    }

    /**
     * Confirm checkout and place order
     *
     * @param  CheckoutConfirmRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function confirm(CheckoutConfirmRequest $request): mixed
    {
        try {
            $checkout = CheckoutService::getInstance();
            $data     = $request->all();
           $razorpayOrder = [];
            unset($data['reference']);
            if ($data) {
                $checkout->updateValues($data);
            }

            $order = $checkout->confirm();
            // echo "<pre> "; print_r($order); echo "</pre>"; exit; // Debugging line to check incoming data
            // exit; // Stop execution after printing data for debugging

            StateMachineService::getInstance($order)->changeStatus(StateMachineService::UNPAID, '', true);
             
            // Create Razorpay order for the total amount of the order
            try {

                    $this->razorpay = new RazorpayService();
                    $rzresponse= $this->razorpay->createOrder($order->total);
                    $razorpayOrder =[
                        'rzrpayment_order_id' => $rzresponse['id'],
                        'amount' => $order->total,
                        'site_order_number' => $order->number,
                        'order_id' => $order->id,
                        'rzresponse' => $rzresponse
                    ];
        
                    // Update order with Razorpay order ID for future reference (optional)
                    $paymentData = ['charge_id' => $rzresponse['id'], 'amount' => $order->total, 'paid' => false, 'reference' => ""];
                    PaymentRepo::getInstance()->createOrUpdatePayment($order->id, $paymentData);                    
                    $order->billing_method_name = 'Razorpay';
                    $order->save(); 
                    
             } catch (Exception $e) {
                return json_fail('Razorpay configuration error: ' . $e->getMessage());
             }

             return json_success(front_trans('common.submitted_success'), $razorpayOrder);

        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
