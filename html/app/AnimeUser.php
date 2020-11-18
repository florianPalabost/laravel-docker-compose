<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeUser extends Model
{
    use HasFactory;

    protected $table = 'anime_user';
    protected $fillable = [
        'id',
        'anime_id',
        'user_id',
        'like',
        'watch',
        'want_to_watch'
    ];

    public function anime()
    {
        return $this->belongsTo('App\Anime');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
