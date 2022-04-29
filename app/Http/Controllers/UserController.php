<?php

namespace App\Http\Controllers;

use App\Models\User;
use Aerni\Spotify\Spotify;
use Illuminate\Http\Request;
use Aerni\Spotify\SpotifySeed;
use Aerni\Spotify\PendingRequest;
use Aerni\Spotify\SpotifyRequest;
use App\Models\TrackArtists;
use App\Models\UsersListening;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
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

    public function syncListningOld(User $user)
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

    public function syncListning(User $user)
    {
        $spotifyURL = 'https://api.spotify.com/v1/';
        $endpoint = $spotifyURL.'me/player/recently-played';
        $result = [];
        $token = $user->sp_token;

        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ])->get($endpoint);


        if($data && $data->status() == 200) {
            $response = $data->body();
            $result = json_decode($response, true);

            if(isset($result) && isset($result['items']) && $result['items']) {
                foreach($result['items'] as $key => $items) {
                    $playedAt = Carbon::parse($items['played_at'])->format('Y-m-d H:i:s');
                    $track = $items['track'];
                    $artists = collect($track['artists'])->pluck('id');
                    $trackId = $track['id'];
                    $trackName = $track['name'];

                    $listingData = UsersListening::updateOrcreate([
                        'user_id' => $user->id,
                        'spotify_track_id' => $trackId,
                    ],
                    [
                        'track_name' => $trackName,
                        'played_at' => $playedAt
                    ]);

                    $listning_id = $listingData->id;
                    foreach($artists->toArray() as $artist) {
                        TrackArtists::updateOrcreate([
                            'listning_id' => $listning_id,
                            'artist_id' => $artist
                        ]);
                    }
                }
            }
        }

        return redirect('home');
    }
}
