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
            $data  = AdminRepo::getInstance()->handleData($data);
            $admin  = Admin::query()->where('email', $email)->first();
            if (empty($admin)) {
                $admin = new Admin;
            }

            // echo "<pre>";
            // print_r($data);
            // exit;

            $admin->fill($data);
            $admin->saveOrFail();
            if (!empty($data['roles'])) {
                $admin->assignRole($data['roles']);
            }

                // Send verification email
            if (!$admin->hasVerifiedEmail()) {
                $admin->sendEmailVerificationNotification();
            }

            return redirect(panel_route('products.index'))
                ->with('instance', $admin)
                ->with('success', panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return redirect(panel_route('register.index'))
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}
