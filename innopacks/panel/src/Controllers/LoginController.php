<?php

namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InnoShop\Panel\Requests\LoginRequest;
use InnoShop\Common\Repositories\AdminRepo;
use InnoShop\Common\Models\Admin;
use App\Services\TwilioSmsService;

class LoginController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
        if (auth('admin')->check()) {
            return redirect()->back();
        }

        if ($request->has('locale')) {
            session(['panel_locale' => $request->get('locale')]);
            return redirect(panel_route('login.index'));
        }

        return inno_view('panel::login');
    }

    /**
     * Login post request
     *
     * @param LoginRequest $request
     * @return mixed
     * @throws Exception
     */
    public function store(LoginRequest $request): mixed
    {
        $redirectUri = session('panel_redirect_uri');

        if (auth('admin')->attempt($request->validated())) {
            if ($redirectUri) {
                session()->forget('panel_redirect_uri');
                return redirect()->to($redirectUri);
            }

            return redirect(panel_route('products.create'));
        }

        return redirect()->back()
            ->with('instance', auth('admin')->user())
            ->with(['error' => trans('auth.failed')])
            ->withInput();
    }

    // public function store(LoginRequest $request): mixed
    //     {
    //         $credentials = $request->validated();
    //         $role = null;
    //         // $admin = Admin::where('email', $credentials['email'])->first();
    //         $admin = Admin::with('roles')->where('email', $credentials['email'])->first();            
    //         if (!$admin) {
    //             return redirect()->back()
    //                 ->with(['error' => trans('auth.failed')])
    //                 ->withInput();
    //         }
            
           
    //         $role = $admin->roles->pluck('name')->first();
    //         if ($role === 'seller') {

    //             // echo 'Seller login'; exit;
    //             if (!$admin->active || !$admin->phone_verified_at) {
    //                 return redirect()->back()
    //                     ->withErrors([
    //                     'error' => 'Your account is not verified yet. Please verify OTP first.'
    //                     ])
    //                     ->withInput();
    //                     }

    //                     if (auth('admin')->attempt($credentials)) {
    //                     $redirectUri = session('panel_redirect_uri');

    //                     if ($redirectUri) {
        //                     session()->forget('panel_redirect_uri');
        //                     return redirect()->to($redirectUri);
    //                     }

    //                     return redirect(panel_route('products.create'));
    //                 }

    //             return redirect()->back()
    //                 ->with(['error' => trans('auth.failed')])
    //                 ->withInput();
                
    //         }else{
    //             // echo 'admin login'; exit;
    //             $redirectUri = session('panel_redirect_uri');
    //             if (auth('admin')->attempt($request->validated())) {
    //                 if ($redirectUri) {
    //                     session()->forget('panel_redirect_uri');

    //                     return redirect()->to($redirectUri);
    //                 }

    //                 // return redirect(panel_route('home.index'));
    //                 return redirect(panel_route('products.create'));
    //             }

    //             return redirect()->back()
    //                 ->with('instance', auth('admin')->user())
    //                 ->with(['error' => trans('auth.failed')])->withInput();
    //         }

    // }




    /**
     * Seller Account Signup page
     */
    public function register(Request $request): mixed
    {
        
    //     ini_set( 'display_errors', 1 );
    // error_reporting( E_ALL );
    // $from = "info@buysellghar.com";
    // $to = "josan.sandeep@gmail.com";
    // $subject = "PHP Mail Test script";
    // $message = "This is a test to check the PHP Mail functionality";
    // $headers = "From:" . $from;
    // if(mail($to,$subject,$message, $headers)){
    //     echo "Test email sent";
    // }
    
        
        if (auth('admin')->check()) {
            return redirect()->back();
        }

        if ($request->has('locale')) {
            session(['panel_locale' => $request->get('locale')]);
            return redirect(panel_route('login.index'));
        }

        return inno_view('panel::register');
    }

    /**
     * Seller register + send OTP via Twilio
     */
   public function store_seller(Request $request, TwilioSmsService $twilio): mixed
    {
        
        $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|max:100|unique:admins,email',
            'password'    => 'required|string|min:6',
            'whatsapp_no' => [
                'required',
                // 'regex:/^(\+91|91)?[6-9]\d{9}$/',
                'unique:admins,whatsapp_no',
            ],
            'roles'       => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['active'] = 0;
            $data['whatsapp_no'] = trim((string) $request->whatsapp_no);

            $data = AdminRepo::getInstance()->handleData($data);

            
            // Generate 6-digit OTP
            $otp = (string) random_int(100000, 999999);

            $admin = new Admin();
            $admin->fill($data);

            // Save OTP in DB
            $admin->sms_otp = $otp;
            $admin->sms_otp_expires_at = now()->addMinutes(10);
            $admin->sms_otp_sent_at = now();
            $admin->sms_otp_attempts = 0;
            $admin->sms_otp_resend_count = 0;

            if (!$admin->saveOrFail()) {
                throw new \Exception('Failed to save admin details.');
            }

            if (!empty($data['roles'])) {
                $admin->assignRole($data['roles']);
            }
           
            // Send OTP SMS
            
            try{
                $phone = $this->formatIndianPhone($admin->whatsapp_no);
                // Send OTP SMS
                $twilio->sendOtp($phone, $otp);
                
            } catch (TwilioException $e) {
                Log::error(
                    'Could not send SMS notification.' .
                    ' Twilio replied with: ' . $e
                );
            }
            

            // $data = $request->all();
            // echo "<pre>";
            // print_r($admin);
            // exit;

            DB::commit();

            return redirect()->to(panel_route('register.verify', $admin->id))
                ->with('success', 'OTP sent successfully to your mobile number.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect(panel_route('register.index'))
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage()
                ]);
        }
    }

    /**
     * OTP verification page
     */
    public function verifyForm($id)
    {
        $admin = Admin::findOrFail($id);

        if ($admin->active == 1) {
            return redirect()->to(panel_route('login.index'))
                ->with('success', 'Your mobile number is verified. Please login.');
        }

        return inno_view('panel::verify-sms-otp', compact('admin'));
    }

    /**
     * Verify OTP from Twilio
     */
    public function verify_otp(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|integer|exists:admins,id',
            'otp'      => 'required|digits:6',
        ]);

        try {
            $admin = Admin::findOrFail($request->admin_id);

            if ($admin->active == 1) {
                return redirect(panel_route('login.index'))
                    ->with('success', 'Mobile number already verified. Please login.');
            }

            // Block if too many attempts
            if ($admin->sms_otp_attempts >= 5) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'otp' => 'Too many invalid attempts. Please resend OTP.'
                    ]);
            }

            // Check OTP exists
            if (empty($admin->sms_otp)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'otp' => 'OTP not found. Please resend OTP.'
                    ]);
            }

            // Check OTP expiry
            if (!$admin->sms_otp_expires_at || now()->gt($admin->sms_otp_expires_at)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'otp' => 'OTP has expired. Please resend OTP.'
                    ]);
            }

            // Compare DB OTP with entered OTP
            if ((string) $admin->sms_otp !== (string) $request->otp) {
                $admin->increment('sms_otp_attempts');

                return back()
                    ->withInput()
                    ->withErrors([
                        'otp' => 'Invalid OTP.'
                    ]);
            }

            // OTP verified successfully
            $admin->update([
                'active'                => 1,
                'phone_verified_at'     => now(),
                'sms_otp'               => null,
                'sms_otp_expires_at'    => null,
                'sms_otp_sent_at'       => null,
                'sms_otp_attempts'      => 0,
                'sms_otp_resend_count'  => 0,
            ]);

            return redirect()->to(panel_route('login.index'))
                ->with('success', 'Mobile number verified successfully. You can login now.');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors([
                    'otp' => $e->getMessage()
                ]);
        }
    }

    /**
     * Resend OTP
     */
    public function resend_otp($id, TwilioSmsService $twilio)
    {
        try {
            $admin = Admin::findOrFail($id);

            if ($admin->active == 1) {
                return back()->with('success', 'This number is already verified.');
            }

            // Cooldown 60 seconds
            if ($admin->sms_otp_sent_at && now()->diffInSeconds($admin->sms_otp_sent_at) < 60) {
                return back()->withErrors([
                    'error' => 'Please wait 60 seconds before requesting another OTP.'
                ]);
            }

            // Max resend count
            if ($admin->sms_otp_resend_count >= 5) {
                return back()->withErrors([
                    'error' => 'OTP resend limit reached. Please try again later.'
                ]);
            }

            $otp = (string) random_int(100000, 999999);
            $phone = $this->formatIndianPhone($admin->whatsapp_no);

            $twilio->sendOtp($phone, $otp);

            $admin->update([
                'sms_otp'              => $otp,
                'sms_otp_expires_at'   => now()->addMinutes(10),
                'sms_otp_sent_at'      => now(),
                'sms_otp_attempts'     => 0,
                'sms_otp_resend_count' => $admin->sms_otp_resend_count + 1,
            ]);

            return back()->with('success', 'OTP resent successfully.');

        } catch (\Throwable $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Convert Indian mobile to E.164
     * Example: 9876543210 => +919876543210
     */
    private function formatIndianPhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '91') && strlen($phone) === 12) {
            return '+' . $phone;
        }

        if (strlen($phone) === 10) {
            return '+91' . $phone;
        }

        if (str_starts_with($phone, '0') && strlen($phone) === 11) {
            return '+91' . substr($phone, 1);
        }

        // If already contains country code in some other format, fallback
        return '+' . ltrim($phone, '+');
    }


    public function sendSms(TwilioVerifyService $twilio)
    {
       
        $receiverNumber = "+9041840363"; // Replace with recipient number in E.164 format
        $message = "Hello from Laravel 12 and Twilio!";

        try {
            $account_sid = config('services.twilio.sid');
            $auth_token = config('services.twilio.auth_token');
            $twilio_number = config('services.twilio.from');

            // $client = new Client($account_sid, $auth_token);
            
            // $client->messages->create($receiverNumber, [
            //     'from' => $twilio_number,
            //     'body' => $message
            // ]);

            $phone = $this->formatIndianPhone($receiverNumber);

            // Send OTP using Twilio Verify
            $twilio->sendOtp($phone);

            return response()->json(['status' => 'SMS Sent Successfully!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}