<?php

namespace App\Utilities;

class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;

    /**
     * FilterBuilder constructor.
     * @param $query
     * @param $filters
     * @param $namespace
     */
    public function __construct($query, $filters, $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }


    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            $normailizedName = ucfirst($name);
            $class = $this->namespace . "\\{$normailizedName}";

            if (! class_exists($class)) {
                continue;
            }

            if (is_array($value)) {
                foreach ($value as $val) {
                    $this->checkToHandle($class, $val);
                }
            } else {
                $this->checkToHandle($class, $value);
            }
        }

        return $this->query;
    }

    public function checkToHandle($class, $val)
    {
        if (strlen($val)) {
            (new $class($this->query))->handle($val);
        } else {
            (new $class($this->query))->handle();
        }
    }
}
