<?php

namespace App\Utilities\AnimesFilters;

use App\Utilities\FilterContract;
use App\Utilities\QueryFilter;

class Subtypes extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->orWhere('subtype', $value);
//        $this->query->where(function ($q) use ($value) {
//            return $q->orWhere('subtype', $value);
//        });
    }
}
