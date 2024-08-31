<?php

// namespace Laravel\Fortify\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
// use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Fortify;
use App\Http\Requests\AuthRequest;

// use Illuminate\Routing\Pipeline;
// use Laravel\Fortify\Actions\AttemptToAuthenticate;
// use Laravel\Fortify\Actions\CanonicalizeUsername;
// use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
// use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
// use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
// use Laravel\Fortify\Contracts\LoginViewResponse;
// use Laravel\Fortify\Contracts\LogoutResponse;
// use Laravel\Fortify\Features;
// use Laravel\Fortify\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        return $this->loginPipeline($request)->then(function ($request) {
            return app(LoginResponse::class);
        });
    }

    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function register(AuthRequest $request,
                          CreatesNewUsers $creator): RegisterResponse
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }
        event(new Registered($user = $creator->create($request->all())));
        $this->guard->login($user);
        return app(RegisterResponse::class);
    }

}
