<?php

namespace App\Utilities\AnimesFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Genres extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->whereHas('genres', function ($q) use ($value) {
            return $q->where('name', $value);
        });
    }
}
