@extends('layouts.app')

@section('content')
    <div class="container-fluid contenedor text-center">
        <h1 class="text-center">Animes</h1>
        <div class=" container text-center">
            @foreach($animes as $anime)
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 container_foto ">
                <div class="ver_mas text-center">
                    <span  class="lnr lnr-eye"></span>
                </div>
                <article class="text-left">
                    <h2>{{$anime->title}}</h2>
                    <h4 class="synopsis">{{$anime->synopsis}}</h4>
                </article>
                <img src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
            </div>
            @endforeach
        </div>
    </div>
@endsection
