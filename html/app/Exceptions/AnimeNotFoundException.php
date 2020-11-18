<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

// BP : extends Exception which is closer of your exception
class AnimeNotFoundException extends ModelNotFoundException
{
    public function report() {
        Log::debug('Anime not found');
    }
}
