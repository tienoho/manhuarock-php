@extends('themes.hentaiz.layouts.full')
@section('title', getConf('meta')['home_title'])
@section('description', getConf('meta')['home_description'])
@section('url', url('home'))

@section("moi-cap-nhat")
    <?php
    $moicapnhat = (new Models\Manga())->new_update($page, getConf('site')['newupdate_home']);
    ?>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div class="d-flex flex-column"><h2 class="h3 font-weight-light mb-0">{{ L::_("New Update") }}</h2> <span
                    class="small text-white-50"> {{ timeago($moicapnhat[0]->last_update) }} </span></div>
        <a class="btn btn-outline-light d-none d-md-block" href="/hentai-vietsub/">Tất cả </a>
    </div>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-6 row-cols-xxl-12 g-2 mb-3 text-center videos">

        @foreach($moicapnhat as $manga)
        <div class="col text-center" data-id="{{ $manga->id }}">
            <div class="card bg-dark h-100 hover-shadow">
                <img class="card-img rounded h-100" src="{{ $manga->cover }}" alt="{{ $manga->name }}" loading="lazy">

                <div class="card-img-overlay d-flex justify-content-end"></div>
                <div class="card-img-overlay d-flex justify-content-end align-items-end mb-5">

                </div>
                <div class="card-body px-0 py-1">
                    <h3 class="card-title h6 text-truncate mb-0 mt-1"><a
                                class="stretched-link link-light font-weight-light"
                                href="{{ manga_url($manga) }}"> {{ $manga->name }} </a></h3>
                    <div class="text-truncate text-white-50 font-weight-normal small">{{ (!empty($manga->other_name) ? $manga->other_name : L::_("Updating")) }}</div>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="d-block d-md-none mt-3 mb-3">
        <a class="btn btn-block btn-outline-light" href="/hentai-vietsub/">
            Xem tất cả </a>
    </div>
@stop

@section("top-ngay")
    <?php
    $top_ngay = (new Models\Manga())->top_views('views_day', 12);
    ?>
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div class="d-flex flex-column"><h2 class="h3 font-weight-light mb-0">{{ L::_("Top Day") }}</h2> <span
                    class="small text-white-50"> {{ timeago($top_ngay[0]->last_update) }} </span></div>
        <a class="btn btn-outline-light d-none d-md-block" href="/hentai-vietsub/">Tất cả </a>
    </div>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-6 row-cols-xxl-12 g-2 mb-3 text-center videos">

        @foreach($top_ngay as $manga)
            <div class="col text-center" data-id="{{ $manga->id }}">
                <div class="card bg-dark h-100 hover-shadow">
                    <img class="card-img rounded h-100" src="{{ $manga->cover }}" alt="{{ $manga->name }}" loading="lazy">

                    <div class="card-img-overlay d-flex justify-content-end"></div>
                    <div class="card-img-overlay d-flex justify-content-end align-items-end mb-5">

                    </div>
                    <div class="card-body px-0 py-1">
                        <h3 class="card-title h6 text-truncate mb-0 mt-1"><a
                                    class="stretched-link link-light font-weight-light"
                                    href="{{ manga_url($manga) }}"> {{ $manga->name }} </a></h3>
                        <div class="text-truncate text-white-50 font-weight-normal small">{{ (!empty($manga->other_name) ? $manga->other_name : L::_("Updating")) }}</div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="d-block d-md-none mt-3 mb-3">
        <a class="btn btn-block btn-outline-light" href="/hentai-vietsub/">
            Xem tất cả </a>
    </div>
@stop

@section("content")
    <div class="container-fluid py-3">

        @yield('moi-cap-nhat')
        @yield("top-ngay")

    </div>
@stop