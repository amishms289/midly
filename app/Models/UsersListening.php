<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersListening extends Model
{
    use HasFactory;

    protected $table = 'users_listening';

    protected $fillable = [
        'user_id',
        'spotify_track_id',
        'track_name',
        'played_at'
    ];

    // User
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function artists()
    {
        return $this->belongsToMany(TrackArtists::class);
    }
}
