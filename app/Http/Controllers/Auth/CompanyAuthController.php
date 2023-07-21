<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('company')->check()) {
            return redirect()->route('company.dashboard');
        } else {
            return view('auth.companyLogin');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('company')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            // $user = auth()->guard('company')->user();
            return redirect()->route('company.dashboard');
        } else {
            return redirect()->back()->withError('Credentials doesn\'t match.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index');
    }
}
