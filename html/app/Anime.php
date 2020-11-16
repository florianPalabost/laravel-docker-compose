<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Anime extends Model
{
    use HasFactory;
    use Searchable;
    protected $primaryKey = 'id';

    protected $fillable = [
        'anime_id',
        'title',
        'synopsis',
        'rating',
        'start_date',
        'end_date',
        'subtype',
        'status',
        'poster_image',
        'episode_count',
        'episode_length',
        'youtube_video_id'
    ];

    public function searchableAs()
    {
        return "anime_index";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres() {
        return $this->belongsToMany('App\Genre', 'anime_genre');
    }

    public function users() {
        return $this->belongsToMany('App\User', 'anime_user')
            ->withPivot(['like', 'watch', 'want_to_watch'])->as('stat_anime');
    }

}
