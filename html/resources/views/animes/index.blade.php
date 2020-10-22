@extends('layouts.app')

@section('title')
    Animes
@endsection
@section('content')
    <div class="container-fluid contenedor text-center">
        <h1 class="text-center">Animes</h1>
        <div class="h-100 w-100">
            <div class="row h-100 justify-content-center align-items-center">
                @foreach($animes as $anime)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 container_foto ">
                        <a href="{{route('animes.show', $anime->title)}}">
                            <div class="ver_mas text-center">
                                <span  class="lnr lnr-eye"><i class="far fa-eye"></i></span>
                            </div>
                            <article class="text-left">
                                <h2>{{$anime->title}}</h2>
                                <h4 class="synopsis">{{$anime->synopsis}}</h4>
                            </article>
                            <img src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="d-flex">
                <div class="mx-auto">
                    {{$animes->links("pagination::bootstrap-4")}}
                </div>

        </div>
    </div>
@endsection

