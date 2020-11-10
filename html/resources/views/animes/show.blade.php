@extends('layouts.app')
@section('title')
    @if(!empty($anime) && !empty($anime->title))
        @if(strlen($anime->title) > 50)
            {{\Illuminate\Support\Str::limit($anime->title, 50)}}
        @else
            {{$anime->title}}
        @endif
    @endif
@endsection
@section('content')
    {{ Breadcrumbs::render('anime', $anime) }}
<div class="container">
    @if(!empty($anime))
        <div class="row justify-content-center mt-5">
            @if(!empty($anime->poster_image) && !empty($anime->title))
            <div class="col">
                <div class="img-container">
                    <img class="image" src="{{$anime->poster_image}}" alt="image_{{$anime->title}}">
                    @if(!empty($anime->youtube_video_id))
                        <div class="overlay">
                            <a class="popup-youtube icon" href="{{$anime->youtube_video_id}}">
                                <i class="far fa-play-circle "></i>
                            </a>
                        </div>
                    @endif
                    <div class="list-inline text-center">
                        <i title="like" id="like" onclick="saveChangeUserAnime('like')" class="{{!empty($stat_anime) && $stat_anime->like ? 'fas red' :'far blue'}} fa-heart fa-3x link"></i>
                        <i title="watch" id="watch" onclick="saveChangeUserAnime('watch')" class="{{!empty($stat_anime) && $stat_anime->watch ? 'fas red' :'far blue'}} fa-check-circle fa-3x link"></i>
                        <i title="want to watch" id="want_to_watch" onclick="saveChangeUserAnime('want_to_watch')" class="{{!empty($stat_anime) && $stat_anime->want_to_watch ? 'fas red' :'far blue'}} fa-eye fa-3x link"></i>
                    </div>
                </div>

            </div>
            @endif
            <div class="col">
                @if(!empty($anime->title))<h1>{{$anime->title}}</h1>@endif
                @if(!empty($anime->subtype))<p>Type : {{$anime->subtype}}</p>@endif
                <p>Episodes : @if(!empty($anime->episode_count)){{$anime->episode_count}}@else ???</p> @endif
                @if(!empty($anime->episode_length))<p>Duration : {{$anime->episode_length}}</p>@endif
                @if(!empty($anime->start_date) && !empty($anime->end_date))<p>from {{$anime->start_date}} to {{$anime->end_date}}</p>@endif
                @if(!empty($anime->rating))<p >Rate : {{$anime->rating}}</p>@endif
                @if (! empty($anime->genres) && count($anime->genres) > 0)
                    <div class="list-inline">
                        @foreach($anime->genres as $genre)
                            <a class="text-black-50" href="{{route('genres.index', $genre->name)}}"><span class="badge badge-info p-2">{{$genre->name}}</span></a>
                        @endforeach
                    </div>
                @else
                    <p class="font-italic">No genre(s) recorded yet !</p>
                @endif

                @if(!empty($anime->synopsis))
                    <div class="justify-content-center mt-3">
                        <p class="text-justify">{{$anime->synopsis}}</p>
                    </div>
                @endif

            </div>
        </div>

        @if(!empty($recommendations) && count($recommendations) > 0)
            <div class="row justify-content-center mt-5">
                <h2>You may also like ...</h2>
            </div>
            <div class="container">
                <div class="row mx-auto my-auto">
                    <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                        <div class="carousel-inner w-100" role="listbox">
                            @foreach($recommendations as $r)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 container_foto  active ">
                                        <a href="{{route('animes.show', $r->title)}}" target="_blank" rel="noreferrer noopenner">
                                            <div class="ver_mas text-center">
                                                <span  class="lnr lnr-eye"><i class="far fa-eye"></i></span>
                                            </div>
                                            <article class="text-left">
                                                <h2>{{$r->title}}</h2>
                                            </article>
                                            <img src="{{$r->image_url}}" alt="image_{{$r->title}}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
@section('script')
    <script src="{{asset('js/carousel.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function($) {
            if ("{{$anime->youtube_video_id}}" !== "") {
                $('.popup-youtube').magnificPopup({
                    type: 'iframe',
                    iframe: {
                        markup: '<div class="mfp-iframe-scaler">' +
                            '<div class="mfp-close"></div>' +
                            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                            '<div class="mfp-title">Some caption</div>' +
                            '</div>',
                        patterns: {
                            youtube: {
                                index: 'youtube.com',
                                id: 'v=',
                                src: "{{$anime->youtube_video_id}}"
                            }
                        }
                    }
                });
            }
        });
        function saveChangeUserAnime(property) {

            Notiflix.Notify.Init({
                position: 'right-bottom'
            });

            $.ajax({
                type: 'POST',
                url: "{{route('ajaxAnimeUser.post')}}",
                data: {
                    _token: "{{ csrf_token() }}",
                    property,
                    anime_id: "{{$anime->id}}"
                },
                success: (data) => {
                    // remove class fas||far (fas,red -> full(is true), far,blue->empty(is false))
                    if($('#'+property).hasClass('red')) {
                        $('#'+property).removeClass('fas');
                        $('#'+property).removeClass('red');
                        $('#'+property).addClass('far');
                        $('#'+property).addClass('blue');
                    }
                    else {
                        $('#'+property).removeClass('far');
                        $('#'+property).removeClass('blue');
                        $('#'+property).addClass('fas');
                        $('#'+property).addClass('red');
                    }
                    Notiflix.Notify.Success('Change recorded');

                },
                error: (err) => {
                    Notiflix.Notify.Failure(err.responseJSON.message);
                }
            });
        }
    </script>
@endsection
@section('css')
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">

    <style>
        .link {
            cursor: pointer;
        }
        .red {
            color: red;
        }
        .blue {
            color: dodgerblue;
        }

        .img-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .image {
            display: block;
            width: 100%;
            height: auto;
        }

        .img-container:hover .overlay {
            opacity: 1;
        }
        .icon {
            color: red;
            font-size: 100px;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .overlay {
            position: absolute;
            top: 50%;
            bottom: 0;
            left: 50%;
            right: 0;
            height: 10%;
            width: 25%;
            opacity: 0;
            transition: .3s ease;
        }
        .icon:hover {
            color: red;
        }
    </style>
@endsection
