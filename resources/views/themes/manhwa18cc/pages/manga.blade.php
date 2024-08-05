<?php
$last_Chap = ($chapters[0])->name;
$type = ucfirst($manga->type) ?? 'Truyện';
$manga->rating_score = floor(($manga->rating_score / 2) * 2) / 2;


$seo_data['title'] = $manga->name . " Tới $last_Chap";
$seo_data['description'] = "Đọc truyện $manga->name tiếng Việt, $type $manga->name cập nhật tới chương MỚI NHẤT tại hoimetruyen.com";

if (!empty($manga->other_name)) {
    $first_otherName = trim(explode(',', $manga->other_name)[0]);
    $seo_data['title'] = "$manga->name [$first_otherName] Tới $last_Chap";
    $seo_data['description'] = "➀✔️ Đọc truyện tranh $manga->name [$last_Chap] tiếng Việt, $type $manga->other_name [$last_Chap] cập nhật tới chương MỚI NHẤT tại hoimetruyen.com";
}

$seo_data['title'] = $seo_data['title'] . ' - HoiMeTruyen.Com';

?>
@extends('themes.manhwa18cc.layouts.full')

@section('title', $seo_data['title'])
@section('description', $seo_data['description'])
@section('url', url('manga', ['m_slug'  => $manga->slug, 'm_id' => $manga->id]))
@section('image', $manga->cover)


@section('schema')
    <script type="application/ld+json">
        {!!manga_schema($manga)!!}
    </script>

    <script type="application/ld+json">
        {!!chaps_schema($manga, $chapters)!!}
    </script>

@stop

@section('content')
    <script>
        var manga_id = {{ $manga->id }},
            manga_rating = {{ $manga->rating_score }}
    </script>
    <div class="manga-content wleft">
        <script type="text/javascript" src="/manhwa18cc/js/jquery.cookie.js"></script>
        @include("themes.manhwa18cc.components.manga.profile")
        <div class="centernav">
            <div class="site-body">
                <div class="content-manga-left">
                    <div class="panel-story-description">
                        <h2 class="manga-panel-title wleft"><i class="icofont-read-book"></i> {{ L::_("Summary") }}
                        </h2>
                        <div class="dsct">
                            @if(!empty(trim($manga->description)))
                                <p>{{ $manga->description }}</p>
                            @else
                                <p>
                                    Đọc <b>{{ $manga->name }}</b> truyện tranh có nét vẽ đẹp sắc nét, nội dung hấp dẫn.
                                    Đọc truyện <b>{{ mb_strtoupper($manga->other_name ?? $manga->name) }}</b> chap mới
                                    nhất ngang raw tại hoimetruyen.com
                                </p>
                            @endif
                        </div>
                    </div>


                    <div class="panel-manga-chapter wleft" id="chapterlist">
                        <h2 class="manga-panel-title wleft"><i
                                    class="icofont-flash"></i> {{ L::_("Latest Chapter Releases") }}</h2>
                        <ul class="row-content-chapter wleft">
                            @foreach($chapters as $chapter)
                                <li class="a-h wleft">
                                    <a class="chapter-name text-nowrap"
                                       href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug]) }}"
                                       title="{{ $manga->name }} {{ $chapter->name }}">{{ $chapter->name }}@if($chapter->name_extend): {{ $chapter->name_extend }}@endif</a>
                                    <span class="chapter-time text-nowrap">{{ time_convert($chapter->last_update) }}</span>
                                </li>
                            @endforeach

                        </ul>
                        <div class="chapter-readmore wleft tcenter">
                            <span style="display: inline;">{{ L::_("Show more") }} <i
                                        class="icofont-simple-down"></i></span>
                        </div>
                    </div>

                    <div class="comment-box wleft">
                        <h3 class="manga-panel-title wleft"><i
                                    class="icofont-speech-comments"></i> {{ L::_("MANGA DISCUSSION") }}
                        </h3>
                        <div id="disqus_thread" style="width: 100%; float: left; padding: 20px 0px">
                            <div id="disqus_empty"></div>
                        </div>
                    </div>
                    <div class="manga-tags wleft">
                        <h5>{{ L::_('Tags') }}:</h5>
                        <div class="tags_list">
                            <a href="#" rel="tag">{{ $manga->name }}</a>
                            <a href="#comic" rel="tag">{{ $manga->name }} comic</a>
                            <a href="#raw" rel="tag">{{ $manga->name }} raw</a>
                            <a href="#komik" rel="tag">{{ $manga->name }} komik</a>
                            <a href="#scan" rel="tag">{{ $manga->name }} Scan</a>
                            <a href="#all-chapters" rel="tag">{{ $manga->name }} all chapters</a>
                            <a href="#webtoon" rel="tag">{{ $manga->name }} webtoon</a>
                            <a href="#manhwa" rel="tag">{{ $manga->name }} manhwa</a>
                        </div>
                    </div>
                    <div class="relation-widget wleft">
                        <div class="block-title wleft">
                            <h4 class="bktitle">
                                <i class="icofont-favourite"></i>
                                {{ L::_("YOU MAY ALSO LIKE") }}
                            </h4>
                        </div>
                        <div class="relation-content sidebar-pp wleft">
                            @foreach( (new \Models\Manga)->RelatedManga(4) as $manga)
                                <div class="p-item r-item">
                                    <a class="pthumb"
                                       href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                       title="{{ $manga->name }}">
                                        <img class="it" data-src="{{ $manga->cover }}"
                                             src="{{ $manga->cover }}" alt="{{ $manga->name }}"/>
                                    </a>
                                    <div class="p-left">
                                        <h4>
                                            <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                               title="{{ $manga->name }}">
                                                {{ $manga->name }} </a>
                                        </h4>
                                        <div class="listsb-chapter">
                                            <div class="chapter-item wleft">
                                                <span class="post-on">{{ time_convert($manga->last_update) }} </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="sidebar">
                    @include("themes.manhwa18cc.components.popular-sidebar")
                </div>
            </div>
        </div>


    </div>

@stop

@section('js-body')
    <script type="text/javascript">

        $(document).ready(function () {
            $('.chapter-readmore span').click(function () {
                $('.panel-manga-chapter ul').css('max-height', 'fit-content');
                $(this).css('display', 'none');
            });

            if (!$.cookie('vote-' + manga_id)) {

                $(".my-rating").starRating({
                    initialRating: manga_rating,
                    totalStars: 5,
                    minRating: 1,
                    starShape: 'straight',
                    starSize: 25,
                    emptyColor: 'lightgray',
                    hoverColor: 'salmon',
                    activeColor: '#f9d932',
                    useGradient: false,
                    callback: function (currentRating, $el) {
                        $.cookie('vote-' + manga_id, '1', {expires: 60 * 24 * 60 * 60 * 1000});
                        $.ajax({
                            url: '/ajax/vote/submit',
                            type: 'POST',
                            data: {
                                'mark': currentRating * 2,
                                'mangaId': manga_id
                            },
                            success: function (data) {
                                $('.is_rate').css('display', 'block');
                            },
                            error: function (e) {
                                console.log(e.message);
                            }
                        });
                    }
                });
            } else {
                $(".my-rating").starRating({
                    initialRating: manga_rating,
                    totalStars: 5,
                    minRating: 1,
                    starShape: 'straight',
                    starSize: 25,
                    emptyColor: 'lightgray',
                    hoverColor: 'salmon',
                    activeColor: '#ffd900',
                    useGradient: false,
                    readOnly: true
                });
            }
        });

        function load_disqus(disqus_shortname) {
            // Prepare the trigger and target
            var is_disqus_empty = document.getElementById('disqus_empty'),
                disqus_target = document.getElementById('disqus_thread'),
                disqus_embed = document.createElement('script'),
                disqus_hook = (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]);

            // Load script asynchronously only when the trigger and target exist
            if (disqus_target && is_disqus_empty) {
                disqus_embed.type = 'text/javascript';
                disqus_embed.async = true;
                disqus_embed.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                disqus_hook.appendChild(disqus_embed);
                is_disqus_empty.remove();
            }
        }

        /*
         * Load disqus only when the document is scrolled till the top of the
         * section where comments are supposed to appear.
         */
        window.addEventListener('scroll', function (e) {
            var currentScroll = document.scrollingElement.scrollTop;
            var disqus_target = document.getElementById('disqus_thread');

            if (disqus_target && (currentScroll > disqus_target.getBoundingClientRect().top - 150)) {
                load_disqus('manhwa18cc');
            }
        }, false);
    </script>
@stop