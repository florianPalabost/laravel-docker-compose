<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $appends = ['animes'];
    protected $fillable = [
        'id',
        'name',
        'description',
        'animes'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function animes()
    {
        return $this->belongsToMany('App\Anime', 'anime_genre');
    }
    public function getAnimesAttribute() {
        return $this->animes()->count();
    }
}
