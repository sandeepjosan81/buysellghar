<?php

namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminForgotPasswordController extends BaseController
{
    /**
     * Show forgot password form
     */
    public function showLinkRequestForm()
    {
        return inno_view('panel::admin.auth.passwords.email');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );
        if($status === Password::RESET_LINK_SENT){
            echo  Password::RESET_LINK_SENT; exit;    
        }
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}