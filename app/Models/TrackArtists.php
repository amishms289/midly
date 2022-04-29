<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackArtists extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'track_artists';

    protected $fillable = [
        'listning_id',
        'artist_id'
    ];
}
