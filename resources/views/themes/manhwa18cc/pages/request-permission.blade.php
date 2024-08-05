@extends('themes.mangareader.layouts.full')
@section('title', 'Yêu Cầu Quyền Đăng Truyện')

@section('content')
    <div id="main-wrapper">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
            @include('themes.mangareader.components.user.request-permission')
            <!--/End: main-content-->

                <!--Begin: main-sidebar-->
            @include('themes.mangareader.components.user.main-sidebar')
            <!--/End: main-sidebar-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@stop

@section('modal')
@stop

@section('js-body')
@stop