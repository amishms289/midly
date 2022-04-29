<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider(String $provider){
        return Socialite::driver($provider)
        ->scopes(['user-read-email', 'user-read-recently-played'])
        ->redirect();
    }

    public function providerCallback(String $provider){
        try{
            $social_user = Socialite::driver($provider)->user();
            // dd($social_user);
            // First Find Social Account
            $account = SocialAccount::where([
                'provider_name'=>$provider,
                'provider_id'=>$social_user->getId()
            ])->first();

            // Find User
            $user = User::where([
                'email'=>$social_user->getEmail()
            ])->first();

            // If Social Account Exist then Find User and Login
            if($account){

                if($user) {
                    $user->update([
                        'name' => $social_user->getName(),
                        'avatar' => $social_user->getAvatar(),
                        'spotify_id' => $social_user->getId(),
                    ]);
                }

                auth()->login($account->user);
                return redirect()->route('home');
            }

            // If User not get then create new user
            if(!$user){
                $user = User::create([
                    'email' => $social_user->getEmail(),
                    'name' => $social_user->getName(),
                    'password' => bcrypt('Midly@123'),
                    'avatar' => $social_user->getAvatar(),
                    'spotify_id' => $social_user->getId(),
                ]);
            }

            // Create Social Accounts
            $user->socialAccounts()->create([
                'provider_id'=>$social_user->getId(),
                'provider_name'=>$provider
            ]);

            // Login
            auth()->login($user);
            return redirect()->route('home');

        }catch(\Exception $e){
            dd($e->getMessage());
            return redirect()->route('login');
        }
    }
}
