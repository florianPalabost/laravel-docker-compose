<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AnimesSelectFilter extends Component
{
    public $nameFilter;
    public $options;
    public $filters;
    public $disabled;

    /**
     * AnimesSelectFilter constructor.
     * @param string $nameFilter
     * @param object|array $options
     * @param array $filters
     * @param bool $disabled
     */
    public function __construct(string $nameFilter, $options, array $filters, bool $disabled = false)
    {
        $this->nameFilter = $nameFilter;
        $this->options = $options;
        $this->filters = $filters;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.animes-select-filter');
    }
}
