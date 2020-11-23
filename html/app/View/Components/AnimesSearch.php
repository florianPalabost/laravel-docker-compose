<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class AnimesSearch extends Component
{
    public $genres;
    public $filters;

    /**
     * Create a new component instance.
     *
     * @param array|Model $genres
     * @param array $filters
     */
    public function __construct($genres, array $filters)
    {
        $this->genres = $genres;
        $this->filters = $filters;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $types = ['TV', 'ONA', 'Movie', 'Music', 'Special'];
        $status = ['current', 'finished', 'unreleased', 'tba', 'upcoming'];
        return view('components.animes-search', compact('types', 'status'));
    }
}
