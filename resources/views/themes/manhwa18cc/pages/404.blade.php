@extends('themes.mangareader.layouts.full')

@section('title', "Nội Dung Này Không Còn Tồn Tại Trên Hoimetruyen.com")

@section('content')
    <div id="main-wrapper" class="page-layout page-404">
        <div class="container">
            <div class="container-404 text-center">
                <div class="c4-big-img"><img src="/mangareader/images/404.png"></div>
                <div class="c4-medium">{{ L::_("Oops, sorry we can't find that page!") }}</div>
                <div class="c4-small">{{ L::_("Either something went wrong or the page doesn't exist anymore.") }}</div>
                <div class="c4-button">
                    <a href="{{ url("home") }}" class="btn btn-radius btn-focus"><i class="fa fa-chevron-circle-left mr-2"></i>{{ L::_("Back to homepage") }}</a>
                </div>
            </div>
        </div>
    </div>
@stop