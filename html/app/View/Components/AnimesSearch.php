<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class AnimesSearch extends Component
{
    public $genres;

    /**
     * Create a new component instance.
     *
     * @param array|Model $genres
     */
    public function __construct($genres)
    {
        $this->genres = $genres;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.animes-search');
    }
}
