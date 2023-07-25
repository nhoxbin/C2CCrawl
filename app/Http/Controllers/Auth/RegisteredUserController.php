<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Ixudra\Curl\Facades\Curl;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:12|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $curl = Curl::to('http://kpi.mobifone5.vn:8088/C2C/loginByMobilev2')
            ->withHeaders([
                'User-Agent' => 'okhttp/3.12.12',
                'Host' => 'kpi.mobifone5.vn:8088'
            ])->withData([
                'account' => $request->phone,
                'appVersion' => 'ios - 2.10.3',
                'deviceName' => 'Model: iPhone X - DeviceId: iPhone10,6 - DeviceName: iPhone',
                'systemName' => 'iOS - 16.4.1',
            ])->asJson(true)->post();

        if ($curl['code'] != 200) {
            throw ValidationException::withMessages([
                'phone' => [$curl['msg']],
            ]);
        }

        $user = User::create([
            'name' => $curl['data']['fullName'],
            'email' => $curl['data']['email'],
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user->c2cuser()->create([
            'pw' => $curl['data']['pw'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
