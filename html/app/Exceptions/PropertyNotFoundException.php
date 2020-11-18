<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class PropertyNotFoundException extends Exception
{
    public function report() {
        Log::debug('Property not found');
    }
}
