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
                <div class="img-container">
                 @if(!empty($anime->youtubeVideoId))
                        <img class="image" src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
                    <div class="overlay">
                        <a class="popup-youtube icon" href="{{$anime->youtubeVideoId}}">
                            <i @if(!empty($anime->youtubeVideoId)) class="far fa-play-circle "></i>@endif
                        </a>
                    </div>
                @else
                        <img class="img-circle" src="{{$anime->posterImage}}" alt="image_{{$anime->title}}">
                @endif
                </div>

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
