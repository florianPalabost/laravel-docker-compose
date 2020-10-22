@extends('layouts.app')
@section('title')
    @if(!empty($anime))
        {{$anime->title}}
    @endif
@endsection
@section('content')
<div class="container">
    @if(!empty($anime))
        <div class="row justify-content-center mt-5">
            @if(!empty($anime->posterImage) && !empty($anime->title))
            <div class="col">
                @if(!empty($anime->youtubeVideoId))
                    <a class="popup-youtube img-container" href="{{$anime->youtubeVideoId}}">
                        <img class="img-circle" src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
                        <i @if(!empty($anime->youtubeVideoId)) class="far fa-play-circle fa-5x play"></i>@endif
                    </a>
                @else
                    <img class="img-circle" src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
                @endif
            </div>
            @endif
            <div class="col">
                <h1 @if(!empty($anime->title))>{{$anime->title}}</h1>@endif
                <p @if(!empty($anime->subtype))>Type : {{$anime->subtype}}</p>@endif
                <p @if(!empty($anime->episodeCount))>Episodes : {{$anime->episodeCount}}</p>@endif
                <p @if(!empty($anime->episodeLength))>Duration : {{$anime->episodeLength}}</p>@endif
                <p @if(!empty($anime->startDate) && !empty($anime->endDate))>from {{$anime->startDate}} to {{$anime->endDate}}</p>@endif
                <p @if(!empty($anime->rating))>Rate : {{$anime->rating}}</p>@endif
            </div>
        </div>
        <div @if(!empty($anime->synopsis)) class="row justify-content-center mt-5">
            <p class="text-justify">{{$anime->synopsis}}</p>
        </div>
        @endif
    @endif
</div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function($) {
            if ("{{$anime->youtubeVideoId}}" !== "") {
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
                                src: "{{$anime->youtubeVideoId}}"
                            }
                        }
                    }
                });
            }

        });
    </script>
@endsection
@section('css')
    <style>

        .img-container {
            /*position: absolute;*/
        }

        .img-container img:hover {
            opacity: 0.5;
            z-index: 501;
        }

        .img-container img:hover + i {
            display: block;
            z-index: 500;
        }

        .img-container i {
            display: none;
            position: absolute;
            margin-left:43%;
            margin-top:40%;
        }

        .img-container img {
            /*position:absolute;*/

        }

    </style>
@endsection
