<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable = [
        'anime_id',
        'title',
        'synopsis',
        'rating',
        'startDate',
        'endDate',
        'subtype',
        'status',
        'posterImage',
        'episodeCount',
        'episodeLength',
        'youtubeVideoId'
    ];
}
