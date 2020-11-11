<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class AnimesList extends Component
{
    public $animes;

    public $title;

    /**
     * Create a new component instance.
     *
     * @param array|Model $animes
     */
    public function __construct($animes, $title = '')
    {
        $this->animes = $animes;
        $this->title = $title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.animes-list');
    }
}
