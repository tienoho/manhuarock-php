@extends('themes.mangareader.layouts.full')

@section('title', 'Tìm kiếm truyện nâng cao')

@section('content')
    <div id="main-wrapper" class="layout-page page-az page-filter">
        <div class="container">

            <div class="prebreadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">{{ L::_('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ L::_('Manga Filter') }}</li>
                    </ol>
                </nav>
            </div>


            <div class="page-search-wrap">
                <!--Begin: Section film list-->
                <section class="block_area block_area_search">
                    <div id="filter-block">
                        <form method="get">
                            <div id="cate-filter" class="category_filter">
                                <div class="category_filter-content mb-5">
                                    <div class="cfc-min-block">
                                        <div class="ni-head mb-3"><strong>{{ L::_('Filter') }}</strong></div>
                                        <div class="cmb-item cmb-type">
                                            <div class="ni-head">{{ L::_('Type') }}</div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="type">
                                                        <option value="">{{ L::_('All') }}</option>

                                                        @foreach(allComicType() as $type_id => $type_name)
                                                            @if($type === $type_id)
                                                                <option selected value="{{ $type_id }}">{{ $type_name }}</option>
                                                            @else
                                                                <option value="{{ $type_id }}">{{ $type_name }}</option>
                                                            @endif
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="cmb-item cmb-status">
                                            <div class="ni-head">{{ L::_('Status') }}</div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="status">
                                                        <option value="">{{ L::_('All') }}</option>

                                                        @foreach(allStatus() as $status_id => $status_name)
                                                            @if($status === $status_id)
                                                                <option selected value="{{ $status_id }}">{{ $status_name }}</option>
                                                            @else
                                                                <option value="{{ $status_id }}">{{ $status_name }}</option>
                                                            @endif
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="cmb-item cmb-sort">
                                            <div class="ni-head">{{ L::_('Sort') }}</div>
                                            <div class="nl-item">
                                                <div class="nli-select">
                                                    <select class="custom-select" name="sort">
                                                        <option selected value="default">{{ L::_('Default') }}</option>
                                                        @foreach(sortType() as $sort_id => $sort_name)
                                                            @if($sort === $sort_id)
                                                                <option selected value="{{ $sort_id }}">{{ $sort_name }}</option>
                                                            @else
                                                                <option value="{{ $sort_id }}">{{ $sort_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="cfc-min-block cfc-min-block-genres mt-3">
                                        <div class="ni-head mb-3"><strong>{{ L::_('Genres') }}</strong></div>
                                        <div class="cmbg-wrap">
                                            <input type="hidden" id="f-genre-ids" name="genres" value="">
                                            @foreach(Models\Taxonomy::GetListGenres() as $genre)

                                                <div data-id="{{ $genre->id }}"
                                                     class="item f-genre-item @if(is_array($genres) && in_array($genre->id, $genres)) active @endif">{{ $genre->name }}</div>
                                            @endforeach

                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="cfc-button mt-4">
                                        <button class="btn btn-focus new-btn"><strong>{{ L::_('Filter') }}</strong>
                                        </button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="manga_list-sbs">
                                    <div class="block_area-header">
                                        <div class="bah-heading">
                                            <h2 class="cat-heading">{{ L::_('Filter Results') }}
                                                <span class="badge badge-secondary ml-1"
                                                      style="font-size: 12px; vertical-align: middle;">{{ $paginate->total_item }}</span>
                                            </h2>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="mls-wrap">
                                        @foreach($filter_list as $manga)
                                            <div class="item item-spc">

                                                <a class="manga-poster"
                                                   href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                                         data-src="{{ $manga->cover }}"
                                                         class="manga-poster-img lazyload"
                                                         alt="{{ $manga->name }}">
                                                </a>
                                                <div class="manga-detail">
                                                    <h3 class="manga-name">
                                                        <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                           title="{{ $manga->name }}">{{ $manga->name }}</a>
                                                    </h3>
                                                    <div class="fd-infor">

                <span class="fdi-item fdi-cate">

                                                        <?php
                    $genres = array_slice(get_manga_data('genres', $manga->id, []), 0, 3);
                    $total_genres = count($genres);
                    $i = 1;
                    ?>
                    @foreach($genres as $key => $genre)
                        <a href="{{ url('genres', ['genres' => $genre->slug]) }}">{{ $genre->name }}</a>
                        @if(!($key + 1 >= $total_genres)),
                        @endif
                    @endforeach

                </span>

                                                        <div class="clearfix"></div>
                                                    </div>

                                                    <div class="fd-list">
                                                        @foreach(get_manga_data('chapters', $manga->id, []) as $chapter)
                                                            <div class="fdl-item">
                                                                <div class="chapter">
                                                                    <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}">
                                                                        <i class="far fa-file-alt mr-2"></i>{{ $chapter->name }}
                                                                    </a>
                                                                </div>
                                                                <div class="release-time"></div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="pre-pagination mt-4">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination pagination-lg justify-content-center">
                                                @if(!($paginate->current_page <= 1))
                                                    <?php
                                                    $prev_page = $paginate->current_page - 1;
                                                    ?>

                                                    <li class="page-item">
                                                        <a class="page-link" data-page="{{ $prev_page }}"
                                                           href="{{ url($url, ['page' => $prev_page], $params) }}">‹</a>
                                                    </li>
                                                @endif

                                                @for($page_in_loop = 1; $page_in_loop <= $paginate->total_page; $page_in_loop++)
                                                    @if ($paginate->total_page > 3)
                                                        @if (( $page_in_loop >= $paginate->current_page - 2 && $page_in_loop <= $paginate->current_page )  || ( $page_in_loop <= $paginate->current_page + 2 && $page_in_loop >= $paginate->current_page))
                                                            @if($page_in_loop == $paginate->current_page)
                                                                <li class="page-item active">
                                                                    <a class="page-link" data-page="{{ $paginate->current_page }}"
                                                                       href="{{ url($url,['page' => $paginate->current_page],$params) }}">{{ $paginate->current_page }}</a>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link" data-page="{{ $page_in_loop }}"
                                                                       href="{{ url($url, ['page' => $page_in_loop], $params) }}">{{ $page_in_loop }}</a>
                                                                </li>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if($page_in_loop == $paginate->current_page)
                                                            <li class="page-item active">
                                                                <a data-page="{{ $paginate->current_page }}"
                                                                   class="page-link"
                                                                   href="{{ url($url, ['page' => $paginate->current_page], $params) }}">{{ $paginate->current_page }}</a>
                                                            </li>
                                                        @else
                                                            <li class="page-item">
                                                                <a data-page="{{ $page_in_loop }}"
                                                                   class="page-link"
                                                                   href="{{ url($url, ['page' => $page_in_loop], $params) }}">{{ $page_in_loop }}</a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endfor


                                                @if(!($paginate->total_page <= $paginate->current_page))
                                                    <?php
                                                    $next_page = $paginate->current_page + 1;
                                                    ?>
                                                    <li class="page-item">
                                                        <a class="page-link" data-page="{{ $next_page }}"
                                                           href="{{ url($url, ['page' => $next_page], $params) }}">›</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
                <!--End: Section film list-->
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@stop

@section('js-body')
    <script>
        $('.f-genre-item').click(function () {
            var genreIds = []
            $(this).toggleClass('active');
            $('.f-genre-item').each(function () {
                $(this).hasClass('active') && genreIds.push($(this).data('id'));
            })
            $('#f-genre-ids').val(genreIds.join(','));
        });
    </script>

@stop