<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimeGenre extends Model
{
    use HasFactory;

    protected $table = 'anime_genre';
    protected $fillable = [
        'id',
        'anime_id',
        'genre_id'
    ];

    public function getId()
    {
        return $this->id;
    }
    public function anime()
    {
        return $this->belongsTo('App\Anime');
    }

    public function genre()
    {
        return $this->belongsTo('App\Genre');
    }
}
