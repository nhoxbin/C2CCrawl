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
                'token' => $user->c2cUser->pw
            ])->asJson(true)->post();
        if ($curl['code'] != 200) {
            throw ValidationException::withMessages([
                'phone' => [$curl['msg']],
            ]);
        }
        $user->c2cUser->pw = $curl['data']['pw'];
        $user->c2cUser->fireBaseDeviceId = $curl['data']['fireBaseDeviceId'];
        $user->c2cUser->save();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/log/save')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088',
                'token' => $request->user()->c2cUser->pw
            ])->withData(['operation' => 'DANG_XUAT'])->asJson(true)->post();
        if ($curl['code'] != 200) {
            return back()->with('msg', $curl['msg']);
        }
        $request->user()->c2cUser->pw = null;
        $request->user()->c2cUser->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
