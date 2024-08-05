@extends('themes.mangareader.layouts.full')
@section('title', L::_('Continue Reading'))

@section('content')
    <div id="main-wrapper">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
                    @include('themes.mangareader.components.user.continue-reading')
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