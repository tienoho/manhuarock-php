@extends('themes.manhwa18cc.layouts.full')
@section('title', $seo_title . ' - Hội Mê Truyện')

@section('content')
    <div class="manga-content wleft">
        <div class="centernav">
            <div class="manga-body wleft">
                <div class="content-manga-list">
                    <div class="list-block wleft">
                        <div class="block-title order-block-title wleft">
                            <h1 class="bktitle">
                                <i class="icofont-favourite"></i>
                                {{ $heading_title }}
                            </h1>
                            @if($sort !== false)
                                <div class="order-nav-tabs">
                                    <span> {{ L::_("Order by") }} </span>
                                    <ul class="c-tabs-content">
                                        @foreach(sortType() as $sort_id => $sort_name)
                                            @if($sort !== $sort_id)
                                                <li class="">
                                                    <a href="{{ url($url, null, ['sort' => $sort_id])  }}" class="">
                                                        {{ $sort_name }}
                                                    </a>
                                                </li>
                                            @else
                                                <li class="active">
                                                    <a href="{{ url($url, null, ['sort' => $sort_id])  }}" class="">
                                                        {{ $sort_name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="manga-lists">
                            @foreach($mangas as $manga)
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
                                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                   title="{{ $manga->name }}">
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

                            <div class="blog-pager wleft tcenter" id="blog-pager">
                                <ul class="pagination">
                                    @if($paginate->current_page <= 1)
                                        <li class="prev disabled"><span>«</span></li>
                                    @else
                                        <li class="prev">
                                            <a href="{{ url(null, ['page' => $paginate->current_page - 1], $params) }}"
                                               data-page="{{ $paginate->current_page - 1 }}">«</a>
                                        </li>
                                    @endif

                                    @if($paginate->current_page - 1 <= 0)
                                        <li class="active">
                                            <a href="{{ url() }}"
                                               data-page="{{ $paginate->current_page }}">{{ $paginate->current_page }}</a>
                                        </li>
                                    @else
                                        <li class="">
                                            <a href="{{ url(null, ['page' => $paginate->current_page - 1], $params) }}"
                                               data-page="{{ $paginate->current_page - 1 }}">{{ $paginate->current_page - 1 }}</a>
                                        </li>
                                        <li class="active">
                                            <a href="{{ url(null, ['page' => $paginate->current_page], $params) }}"
                                               data-page="{{ $paginate->current_page }}">{{ $paginate->current_page }}</a>
                                        </li>
                                    @endif
                                    <?php
                                    $next_pages = [1, 2, 3];
                                    ?>
                                    @foreach($next_pages as $pagenext)
                                        @if($paginate->current_page + $pagenext <=$paginate->total_page)
                                            <li><a href="{{ url(null, ['page' => $paginate->current_page + $pagenext], $params) }}"
                                                   data-page="{{ $paginate->current_page + $pagenext  }}">{{ $paginate->current_page + $pagenext  }}</a>
                                            </li>
                                        @endif
                                    @endforeach


                                    @if($paginate->current_page < $paginate->total_page)
                                        <li class="next">
                                            <a href="{{ url(null, ['page' => $paginate->current_page + 1], $params) }}" data-page="{{ $paginate->current_page + 1 }}">»</a>
                                        </li>
                                    @else
                                        <li class="next disabled">
                                            <span>»</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @stop

        @section('modal')
        @stop

        @section('js-body')
            <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>

            <script type="text/javascript">
                $("img.lazyload").lazyload();

                $(document).ready(function () {
                    $(".my-rating").starRating({
                        totalStars: 5,
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
    </div>
@stop