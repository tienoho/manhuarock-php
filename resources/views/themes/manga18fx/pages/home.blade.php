@extends('themes.manga18fx.layouts.full')
@section('title', getConf('meta')['home_title'])
@section('description', getConf('meta')['home_description'])
@section('url', url('home'))

@include('ads.banner-ngang')
@include('ads.banner-sidebar')

@section('content')
    <div class="manga-content">
        <div class="centernav">
            <div class="site-body">
                @hasSection('banner-ngang')
                    <div class="mb-3">
                        @yield('banner-ngang')
                    </div>
                @endif
                <div class="bixbox" style="margin-bottom: 30px;">
                    <div class="releases">
                        <h2>
                            <i class="icofont-flash"></i>
                            {{ L::_("HOT MANGA UPDATES") }}
                        </h2>
                    </div>
                    <div class="listupd">
                        @foreach((new Models\Manga())->pin_manga(getConf('site')['total_pin']) as $key => $manga)
                            <div class="hot-item">
                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                   title="{{ $manga->name }}">
                                    <div class="chapter-badges">
                                        @if($chapters = get_manga_data('chapters', $manga->id))
                                            {{ $chapters[0]->name }}
                                        @endif
                                    </div>
                                    <img class="lazyload" data-src="{{ $manga->cover }}"
                                         src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs="
                                         alt="{{ $manga->name }}">
                                    <div class="caption">
                                        <h3>{{ $manga->name }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="bixbox" style="margin-bottom: 30px;">
                    <div class="releases">
                        <h2>
                            <i class="icofont-flash"></i>
                            {{ L::_("Most Viewed") }}
                        </h2>
                    </div>
                    <div class="listupd">
                        @foreach((new Models\Manga())->trending_manga(6) as $key => $manga)
                            <div class="hot-item">
                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                   title="{{ $manga->name }}">
                                    <div class="chapter-badges">
                                        @if($chapters = get_manga_data('chapters', $manga->id))
                                            {{ $chapters[0]->name }}
                                        @endif
                                    </div>
                                    <img class="lazyload" data-src="{{ $manga->cover }}"
                                         src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs="
                                         alt="{{ $manga->name }}">
                                    <div class="caption">
                                        <h3>{{ $manga->name }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="content-manga-left">
                    <div class="bixbox">
                        <div class="releases">
                            <h1>
                                <i class="icofont-flash"></i>
                                {{ L::_("LATEST MANGA UPDATES") }}
                            </h1>
                        </div>
                        <div class="listupd">
                            @foreach((new Models\Manga())->new_update($page, getConf('site')['newupdate_home']) as $manga)
                                <div class="page-item">
                                    <div class="bsx-item">
                                        <div class="thumb-manga">
                                            <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                               title="{{ $manga->name }}">
                                                @if($manga->adult)
                                                    <div class="adult-badges">
                                                        18+
                                                    </div>
                                                @endif
                                                <img data-src="{{ $manga->cover }}" class="lazyload"
                                                     src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                     alt="{{ $manga->name }}">
                                            </a>
                                        </div>
                                        <div class="bigor-manga">
                                            <h3 class="tt">
                                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                   title="{{ $manga->name }}">
                                                    {{ $manga->name }} </a>
                                            </h3>
                                            <div class="item-rate">
                                                <div class="mmrate" data-rating="{{ $manga->rating_score / 2 }}"></div>
                                                <span>{{ floor(($manga->rating_score / 2) * 2) / 2 }}</span>
                                            </div>
                                            <div class="list-chapter">
                                                @foreach(array_slice(get_manga_data('chapters', $manga->id, []), 0 , 2) as $chapter)
                                                    <div class="chapter-item wleft">
                                                    <span class="chapter">
                                                        <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}"
                                                           class="btn-link"
                                                           title="{{ $manga->name }} {{ $chapter->name }}"> {{ $chapter->name }} </a>
                                                    </span>
                                                        @if((strtotime('now') - strtotime($chapter->last_update)) < 86400)
                                                            <span class="post-on">
                                                        <span class="c-new-tag">
                                                        <img style="width: 30px; height: 16px;"
                                                             src="/manhwa18cc/images/images-new.gif"
                                                             alt="{{ $manga->name }} {{ $chapter->name }}">
                                                        </span>
                                                    </span>
                                                        @else
                                                            <span class="post-on">
                                                        <span class="c-new-tag">
                                                        {{ time_convert($chapter->last_update) }}
                                                        </span>
                                                    </span>
                                                        @endif
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <?php
                            $current_page = 1;
                            $num = 5
                            ?>
                            <div class="blog-pager" id="blog-pager">
                                <ul class="pagination">
                                    <li class="prev disabled">
                                        <span>«</span>
                                    </li>
                                    @for($i = 1 ; $i <= $num ; $i++)
                                        <li class="{{ $current_page === $i ? 'active' : ''}}">
                                            <a href="{{ url('manga_list', ['page' => $i]) }}"
                                               data-page="{{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="next">
                                        <a href="{{ url('manga_list', ['page' => 2]) }}" data-page="2">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar">
                    @hasSection('banner-sidebar')
                        <div class="mb-3">
                            @yield('banner-sidebar')
                        </div>
                    @endif

                    @include("themes.manga18fx.components.history-sidebar")

                    @include("themes.manga18fx.components.popular-sidebar")

                    @hasSection('banner-sidebar')
                        @yield('banner-sidebar')
                    @endif
                </div>

                @hasSection('banner-ngang')
                    @yield('banner-ngang')
                @endif
            </div>
        </div>


    </div>
@stop

@section('js-body')
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

    <script type="text/javascript">
        $("img.lazyload").lazyload();
        $(document).ready(function () {
            $(".mmrate").starRating({
                totalStars: 5,
                starShape: 'straight',
                starSize: 20,
                emptyColor: 'lightgray',
                hoverColor: 'salmon',
                activeColor: '#ffd900',
                useGradient: false,
                readOnly: true
            });
        });

    </script>
@stop