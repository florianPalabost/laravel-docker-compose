@extends('layouts.app')

@section('title')
    Animes
@endsection
@section('content')
    @isset($title)
    <x-animes-list :animes=$animes :title=$title></x-animes-list>
    @else
        <x-animes-list :animes=$animes></x-animes-list>
    @endisset
@endsection

