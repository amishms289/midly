<?php

namespace App\Http\Controllers;

use App\Models\User;
use Aerni\Spotify\Spotify;
use Illuminate\Http\Request;
use Aerni\Spotify\SpotifySeed;
use Aerni\Spotify\PendingRequest;
use Aerni\Spotify\SpotifyRequest;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function profile(User $user)
    {
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function syncListning(User $user)
    {
        $provider = $provider ?? 'spotify';
        // $social_user = Socialite::driver($provider)->user();
        // dd($social_user);
        $spotify = new Spotify([]);
        // $a = $spotify->artist('4ZPpGYjIb5caOhHhQANO8P')->get();
        // $aa = $spotify->userPlaylists($user->spoti)->get();

        $endpoint = '/me/player/recently-played';
        $request = resolve(SpotifyRequest::class);

        $options = [
            'scope' => [
                'user-read-email',
                'user-read-recently-played'
            ],
        ];

        $parameters = [

            'response_type' => 'code',
            'scope' => isset($options['scope']) ? implode(' ', $options['scope']) : null,
            'show_dialog' => !empty($options['show_dialog']) ? 'true' : null,
            'state' => $options['state'] ?? null,
        ];

        $response = $request->get('/me/player/recently-played', $parameters);
        dd($response);
        // $as = new SpotifySeed();
        // $as->get();


        // $data = new PendingRequest($endpoint);

        // dd($data);

        return view('user.profile', [
            'user' => $user
        ]);
    }
}
