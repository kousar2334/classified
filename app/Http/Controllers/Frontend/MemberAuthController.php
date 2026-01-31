<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberLoginRequest;
use App\Http\Requests\MemberRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class MemberAuthController extends Controller
{
    //
    public function memberLoginPage()
    {
        return view('frontend.auth.login');
    }


    public function memberRegisterPage()
    {
        return view('frontend.auth.register');
    }

    public function memberRegister(MemberRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->type = config('settings.user_type.member');
            $user->status = config('settings.general_status.active');
            $user->password = Hash::make($request['password']);
            $user->save();
            toastNotification('success', 'Registration Completed', 'Success');
            return to_route('member.login');
        } catch (\Exception $e) {
            toastNotification('error', 'Registration failed', 'Error');
            return redirect()->back();
        }
    }


    public function loginAttempt(MemberLoginRequest $request): RedirectResponse
    {
        // Find user by email or phone
        $user = User::where(function ($query) use ($request) {
            $query->where('email', $request->username)
                ->orWhere('phone', $request->username);
        })
            ->where('type', config('settings.user_type.member'))
            ->first();

        // Check if user exists
        if (!$user) {
            throw ValidationException::withMessages([
                'login_error' => 'No account found with this email/phone'
            ]);
        }

        // Check if user is active
        if ($user->status != config('settings.general_status.active')) {
            throw ValidationException::withMessages([
                'login_error' => 'Your account is not active. Please contact administration'
            ]);
        }

        // Verify password manually
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login_error' => 'Invalid password'
            ]);
        }

        // Login the user
        Auth::login($user);
        $request->session()->regenerate();

        toastNotification('success', 'Login Successfully', 'Success');
        return redirect()->route('member.dashboard');
    }


    public function memberLogout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastNotification('success', 'Logout Successfully', 'Success');
        return to_route('member.login');
    }

    public function forgotPasswordPage()
    {
        return view('frontend.auth.forgot-password');
    }

    public function memberDashboard(Request $request)
    {
        return view('frontend.pages.member.dashboard.index');
    }
}
