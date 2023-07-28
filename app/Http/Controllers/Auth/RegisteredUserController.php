<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\C2CHelper;
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

        $c2cHelper = new C2CHelper;
        $curl = $c2cHelper->login($request->phone);

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
