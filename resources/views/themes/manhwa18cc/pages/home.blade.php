@extends('themes.manhwa18cc.layouts.full')
@section('title', 'Hội Mê Truyện - Cổng Truyện Tranh Số Một VN')
@section('description', 'Hội Mê Truyện, Đọc Truyện Vip Miễn Phí Với 100.000 Chương Truyện Tranh Tiếng Việt')
@section('url', url('home'))

@section('content')
    <div class="manga-content wleft">
        <div class="centernav">
            <div class="manga-body wleft">
                <div class="content-manga-list">
                    <div class="list-block popular-block wleft">
                        <div class="block-title wleft">
                            <h2 class="bktitle">
                                <i class="icofont-flash"></i>
                                {{ L::_('HOT MANHWA UPDATES') }}
                            </h2>
                        </div>
                        <div class="popular-items">
                            @foreach((new Models\Manga())->pin_manga(6) as $key => $manga)
                                <div class="hot-item">
                                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                       title="{{ $manga->name }}">
                                        <div class="himg">
                                            <div class="chapter-badges">
                                                @if($chapters = get_manga_data('chapters', $manga->id))
                                                    {{ $chapters[0]->name }}
                                                @endif
                                            </div>
                                            <img class="lazyload" data-src="{{ $manga->cover }}"
                                                 src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs="
                                                 alt="{{ $manga->name }}">
                                        </div>
                                        <div class="caption">
                                            <h4>{{ $manga->name }}</h4>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="list-block wleft">
                        <div class="block-title wleft">
                            <h1 class="bktitle">
                                <i class="icofont-flash"></i>
                                {{ L::_('LATEST MANHWA UPDATES') }}
                            </h1>
                        </div>
                        <div class="manga-lists">
                            @foreach((new Models\Manga())->new_update(1, 24) as $manga)
                                <div class="manga-item">
                                    <div class="bsx wleft">
                                        <div class="thumb">
                                            <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                               title="{{ $manga->name }}">
                                                <img data-src="{{ $manga->cover }}" class="lazyload"
                                                     src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                     alt="{{ $manga->name }}">
                                            </a>
                                        </div>
                                        <div class="data wleft">
                                            <h3>
                                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}" title="{{ $manga->name }}">
                                                    {{ $manga->name }} </a>
                                            </h3>
                                            <div class="item-rate wleft">
                                                <div class="my-rating jq-stars" data-rating="{{ $manga->rating_score / 2 }}"></div>
                                                <span>{{ floor(($manga->rating_score / 2) * 2) / 2 }}</span>
                                            </div>
                                            <div class="list-chapter wleft">
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
                            <div class="blog-pager wleft tcenter" id="blog-pager">
                                <ul class="pagination">
                                    <li class="prev disabled">
                                        <span>«</span>
                                    </li>
                                    @for($i = 1 ; $i <= $num ; $i++)
                                        <li class="{{ $current_page === $i ? 'active' : ''}}">
                                            <a href="{{ url('latest-updated', ['page' => $i]) }}" data-page="{{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="next">
                                        <a href="{{ url('latest-updated', ['page' => 2]) }}" data-page="2">»</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@stop

@section('js-body')
    <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

    <script type="text/javascript">
        $("img.lazyload").lazyload();
        $(document).ready(function () {
            $(".my-rating").starRating({
                totalStars: 5,
                minRating: 1,
                starShape: 'straight',
                starSize: 16,
                emptyColor: 'lightgray',
                hoverColor: 'salmon',
                activeColor: '#ffd900',
                useGradient: false,
                readOnly: true
            });
        });
    </script>

@stop