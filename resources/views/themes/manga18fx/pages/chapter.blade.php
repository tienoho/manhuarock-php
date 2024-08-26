@extends('themes.manga18fx.layouts.full')
<?php
include(ROOT_PATH . '/resources/views/includes/chapter.php');

$chapters = \Models\Chapter::ChapterListByID($manga->id);

?>

@section('title', $metaConf['chapter_title'])
@section('description', $metaConf['chapter_description'])

@section('url', $chapter_url)
@section('image', $manga->cover)

@include('ads.banner-ngang')
@include('ads.banner-sidebar')

@section('content')
    <script>
        var manga_id = {{ $manga->id }}, chapter_id = {{ $chapter->id }}, chapter_name = '{{ $chapter->name }}'
    </script>
    <div class="manga-content wleft">
        <div class="readmanga">
            <div class="centernav">
                @include('themes.manga18fx.components.chapter.breadcrumb')
                <div class="manga-body">
                    <div class="read-manga">
                        @hasSection('banner-ngang')
                            <div class="mt-3 mb-3">
                                @yield('banner-ngang')
                            </div>
                        @endif
                        
                        <div class="chapchange">
                            <h1 class="tcenter">{{ $manga->name }} - {{ $chapter->name }}</h1>
                            @include("themes.manga18fx.components.chapter.chapter-source")
                            @include("themes.manga18fx.components.chapter.navigation")
                        </div>
                        <div class="text-center mt-3">
                            <button id="error_report" class="btn btn-warning" type="button"> {{ L::_("Error Report") }} </button>
                        </div>
                        <div class="read-content tcenter">
                            <div class="waiting" style="margin:auto; max-width: 800px;padding: 70px 0; text-align: -webkit-center; background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
                                {{ L::_("PLEASE WAIT CONTENT ...") }}
                            </div>
                        </div>
                        <div class="chapchange">
                            @include("themes.manga18fx.components.chapter.navigation-footer")
                        </div>

                        @hasSection('banner-ngang')
                            <div class="mt-3">
                                @yield('banner-ngang')
                            </div>
                        @endif

                        <div class="mt-3"></div>
                        @include('themes.manga18fx.components.comment')
                        <div class="mt-5"></div>

                        <div class="related-manga wleft">
                            <h4 class="manga-panel-title"><i class="icofont-star-shape"></i> {{ L::_("You May Also Like") }}</h4>
                            <div class="related-items">
                                @foreach( (new \Models\Manga)->RelatedManga(4) as $manga)
                                    <div class="item">
                                        <div class="rlbsx">
                                            <div class="thumb">
                                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}" title="{{ $manga->name }}">
                                                    <img data-src="{{ $manga->cover }}" src="{{ $manga->cover }}" alt="{{ $manga->name }}">
                                                </a>
                                            </div>
                                            <div class="bigor">
                                                <h5 class="tt">
                                                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                       title="{{ $manga->name }}">
                                                        {{ $manga->name }} </a>
                                                </h5>
                                                <div class="list-chapter">
                                                    @foreach(array_slice(get_manga_data('chapters', $manga->id, []),0,2) as $chapter)
                                                        <div class="chapter-item">
                                                    <span class="chapter">
                                                        <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}"
                                                           class="btn-link"
                                                           title="{{ $manga->name }} {{ $chapter->name }}"> {{ $chapter->name }} </a>
                                                    </span>
                                                            <span class="post-on">{{ time_convert($chapter->last_update) }} </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $(document).ready(function () {
                $('.navi-change-chapter').change(function () {
                    const url = $(this).find(':selected').attr('data-c');
                    window.location.replace(url);
                });
                const current_selected = $('.navi-change-chapter option:selected');
                const next_chap = current_selected.prev().attr('data-c');
                const prev_chap = current_selected.next().attr('data-c');

                $(".navi-change-chapter-btn-next").attr("href", next_chap)
                $(".navi-change-chapter-btn-prev").attr("href", prev_chap)

                if (!next_chap) {
                    $(".navi-change-chapter-btn-next").on('click', function () {
                        alert("Hết chap òi baby")
                    })
                }
                $.get('/ajax/image/list/chap/' + chapter_id + '?mode=vertical&quality=high', function (res) {
                    if (res.status === true) {
                        $(".read-content").html(res.html)
                    }
                })
            });
    </script>

    <script>
        const Lang = {
            enter_error: "{{ L::_("Please enter your error") }}",
            logged_report: "{{ L::_("An error has been reported, we will fix it quickly") }}"
        }

        $(document).ready(function () {
            if (typeof (Storage) !== 'undefined') {
                let manga_history = localStorage.getItem('manga_history');
                let isread = 'isread_' + chapter_id;
                if (!localStorage.getItem(isread)) {
                    localStorage.setItem(isread, 1);
                }
                if (!manga_history) {
                    manga_history = [];
                } else {
                    manga_history = JSON.parse(manga_history)
                    let max_item = 100;
                    manga_history = manga_history.slice(manga_history.length - max_item, max_item);
                }
                manga_history.forEach(function (value, index) {
                    if (value.manga_id !== undefined && value.manga_id === manga_id) {
                        manga_history.splice(index, 1);
                    }
                });
                manga_history.push({
                    manga_id: manga_id,
                    current_reading: {
                        chapter_id: chapter_id,
                        url: window.location.href,
                        name: chapter_name
                    }
                });
                localStorage.setItem('manga_history', JSON.stringify(manga_history));
            }

            $("#error_report").on('click', function () {
                let textReport = prompt(Lang.enter_error, "");
                if (!textReport) {
                    return;
                }
                $.post("/api/report/chapter", {
                    content: textReport,
                    chapter_id: chapter_id
                }, function () {
                    alert(Lang.logged_report)
                });
            })
        });

    </script>
@stop