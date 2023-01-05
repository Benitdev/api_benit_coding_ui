<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SocialAccountService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    //
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->stateless()->user(), $social);
        // auth()->login($user);
        $access_token = $user->createToken('Login Token')->accessToken;
        dd($access_token);
        // return redirect('http://localhost:3000');
        return response()->json([
            'access_token' => $access_token
        ], 200);
    }
}
