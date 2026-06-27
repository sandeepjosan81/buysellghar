<?php


namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\Request;
use InnoShop\Panel\Requests\LoginRequest;
use InnoShop\Common\Repositories\AdminRepo;
use InnoShop\Common\Models\Admin;

class LoginController extends BaseController
{
    /**
     * @param  Request  $request
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
     * @param  LoginRequest  $request
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

            // return redirect(panel_route('home.index'));
            return redirect(panel_route('products.create'));
        }

        return redirect()->back()
            ->with('instance', auth('admin')->user())
            ->with(['error' => trans('auth.failed')])->withInput();
    }
        
    // Seller Acccount Signup details
    public function register(Request $request): mixed
    {
        if (auth('admin')->check()) {
            return redirect()->back();
        }

        if ($request->has('locale')) {
            session(['panel_locale' => $request->get('locale')]);

            return redirect(panel_route('login.index'));
        }

        return inno_view('panel::register');
    }

    public function store_seller(Request $request): mixed{
        try {
            
            $data  = $request->all();            
            $email = $data['email'] ?? '';
            $data['active'] =   0;

            $admin  = Admin::query()->where('email', $email)->first();
            if (empty($admin)) {
                $admin = new Admin;
            }
            $data  = AdminRepo::getInstance()->handleData($data);
            // echo "<pre>";
            // print_r($data);
            // exit;
            $otp = rand(100000, 999999);
            $admin->fill($data);
            $admin->email_otp = $otp;

            $admin->saveOrFail();
            if (!empty($data['roles'])) {
                $admin->assignRole($data['roles']);
            }

            \Mail::raw(
                "Your email verification OTP is: {$otp}",
                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Email Verification OTP');
                }
            );

            return redirect() ->route('register.verify', $admin->id);

            // return redirect(panel_route('products.index'))
            //     ->with('instance', $admin)
            //     ->with('success', panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return redirect(panel_route('register.index'))
                ->withErrors(['error' => $e->getMessage()]);
        }
    }


        public function verifyForm($id)
    {
        $admin = Admin::findOrFail($id);

        return inno_view('panel.verify-email-otp', compact('admin'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'admin_id' => 'required',
            'otp' => 'required'
        ]);

        $admin = Admin::findOrFail($request->admin_id);

        if ($admin->email_otp != $request->otp) {
            return back()->withErrors([
                'otp' => 'Invalid OTP'
            ]);
        }

        $admin->update([
            'email_verified_at' => now(),
            'email_otp' => null,
            'active' => 1
        ]);

        return redirect(panel_route('login.index'))
            ->with('success', 'Email verified successfully.');
    }
}
