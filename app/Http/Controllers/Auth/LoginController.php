<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate(
            [
                'provider_id' => $githubUser->getId(),
            ],
            [
                'email' => $githubUser->getEmail(),
                'name' => $githubUser->getName(),
            ]
        );
    

        // logar o novo usuario 
        auth()->login($user, true);

        // redirecionar para a dashboard
        return redirect('dashboard');
    }
}