<?php

namespace App\Utilities;

class QueryFilter
{

    protected $query;

    /**
     * QueryFilter constructor.
     * @param $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }
}
