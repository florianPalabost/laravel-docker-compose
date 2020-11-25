@extends('layouts.app')

@section('title')
    Search
@endsection
@section('content')

    @isset($genres)
        <x-animes-search :genres="$genres" :filters="$filters"></x-animes-search>
    @endisset

    @isset($title)
        <x-animes-list :animes=$animes :title=$title></x-animes-list>
    @else
        <x-animes-list :animes=$animes></x-animes-list>
    @endisset
@endsection

