<?php

namespace InnoShop\Panel\Controllers;

use InnoShop\Common\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AdminResetPasswordController extends BaseController
{
    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token = null)
    {
        

        return inno_view('panel::admin.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('admins')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Admin $admin, string $password) {
                $admin->forceFill([
                    'password' => Hash::make($password),
                    // 'remember_token' => Str::random(60),
                ])->save();
            }
        );
        

        return $status == Password::PASSWORD_RESET
            ? redirect(panel_route('login.index'))->with('success', 'Password reset successfully.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}