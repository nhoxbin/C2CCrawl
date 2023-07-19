<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\C2CUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Ixudra\Curl\Facades\Curl;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = User::where('phone', '0383534173')->firstOrFail();

        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/user/updateToken')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => C2CUser::first()->token
            ])
            ->withData('fXZBa1A2TqWh2q_bS-0Iu2:APA91bHRcIT-nJCiD9S16orpmWXalm9lfFIvvRJayVazpeLKY6UrZe-crOvcorO9AYn71lqeSIuwt6MhVfm8uXGgQtkRY0jtSDu4IwtewBME6eB5Wrh4QxZoA0LiM5au20gNXYnycI-2')->asJson(true)->post();
        if ($curl['code'] != 200) {
            throw ValidationException::withMessages([
                'phone' => [$curl['msg']],
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
