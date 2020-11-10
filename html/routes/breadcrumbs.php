<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > Animes
Breadcrumbs::for('animes', function ($trail) {
    $trail->parent('home');
    $trail->push('Animes', route('animes.index'));
});

// Home > Animes > [Anime]
Breadcrumbs::for('anime', function ($trail, $anime) {
    $trail->parent('animes');
    $trail->push($anime->title, route('animes.show', $anime->title));
});

