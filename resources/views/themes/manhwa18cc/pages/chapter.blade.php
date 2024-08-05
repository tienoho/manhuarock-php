@extends('themes.manhwa18cc.layouts.full')
<?php
$type = ucfirst($manga->type) ?? 'Truyện';

$seo_data['title'] = "$type $manga->name $chapter->name [Next Chapter " . ($chapter->chapter_index + 1) . "]";
$seo_data['description'] = "➀✔️ Đọc truyện tranh $manga->name $chapter->name tiếng Việt, $type $manga->name $chapter->name ẢNH ĐẸP NHẤT tại hoimetruyen.com";

if (!empty($manga->other_name)) {
    $first_otherName = trim(explode(',', $manga->other_name)[0]);
//    $seo_data['title'] = "$manga->name [$first_otherName] Tới $chapter->name";
    $seo_data['description'] = "➀✔️ Đọc truyện tranh $manga->name $chapter->name tiếng Việt, $type $manga->other_name $chapter->name ẢNH ĐẸP NHẤT tại hoimetruyen.com";
}

if ($manga->type === 'one-shot') {
    $seo_data['title'] = "$type $manga->name $chapter->name";
}

$seo_data['title'] = $seo_data['title'] . ' - HoiMeTruyen.Com';

$chapters = \Models\Chapter::ChapterListByID($manga->id);
?>


@section('title', $seo_data['title'])
@section('description', $seo_data['description'])

@section('url', url('chapter', ['m_slug'  => $manga->slug, 'm_id' => $manga->id, 'c_id' => $chapter->id]))
@section('image', $manga->cover)


@section('data-id', $manga->id)

@section('content')
    <script>
        const manga_id = {{ $manga->id }}, chapter_id = {{ $chapter->id }};
    </script>
    <div class="manga-content wleft">
        <div class="readmanga">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "BreadcrumbList",
                        "itemListElement": [{
                            "@type": "ListItem",
                            "position": 1,
                            "name": "{{ L::_("Home") }}",
                            "item": "{{ url('home') }}"
                        },{
                            "@type": "ListItem",
                            "position": 2,
                            "name": "{{ $manga->name }}",
                            "item": "{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                        },{
                            "@type": "ListItem",
                            "position": 3,
                            "name": "{{ $chapter->name }}"
                        }]
                    }



                    </script>
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ url('home') }}" title="{{ L::_("Read Manga Online") }}">
                                    {{ L::_("Home") }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('manga', ['m_slug'=> $manga->slug, 'm_id' => $manga->id]) }}"
                                   title="{{ $manga->name }}">
                                    {{ $manga->name }} </a>
                            </li>
                            <li>
                                <a class="active" href="{{ url() }}"
                                   title="{{ $manga->name }} {{ $chapter->name }}">
                                    {{ $chapter->name }} </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="manga-body">
                    <div class="read-manga">
                        <div class="chapchange wleft">
                            <h1 class="tcenter">{{ $manga->name }} - {{ $chapter->name }}</h1>
                            @include("themes.manhwa18cc.components.chapter.navigation")
                        </div>

                        <div class="read-content wleft tcenter">
                            <div class="waiting"
                                 style="margin:auto; max-width: 800px;padding: 70px 0; text-align: -webkit-center; background-color: #ffffff; box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;">
                                {{ L::_("PLEASE WAIT CONTENT ...") }}
                            </div>

                        </div>
                        <div class="chapchange">
                            @include("themes.manhwa18cc.components.chapter.navigation")
                        </div>


                        <div class="comment-box wleft">
                            <h3 class="manga-panel-title"><i
                                        class="icofont-speech-comments"></i> {{ L::_("MANGA DISCUSSION") }} </h3>
                            <div id="disqus_thread" style="width: 100%; float: left; padding: 20px 0px">
                                <div id="disqus_empty"></div>
                            </div>
                        </div>

                        <div class="chapter-sumary wleft">
                            <?php
                            foreach (get_manga_data('genres', $manga->id, []) as $genre) {
                                $genres[] = $genre->name;
                            }

                            ?>
                            <h2>{{ $manga->name }} {{ gettype($manga->type) }} Summary</h2>
                            <p>You're read <a rel="nofollow" class="a-h" href="/webtoon/escort-warrior"
                                              title="Escort Warrior">Escort Warrior</a> manga online at <span>Manhwa18.cc</span>.
                                @if(!empty($manga->other_name))
                                    {{ $manga->name }} {{ type_name($manga->type) }} also known
                                    as: {{ $manga->other_name }}.
                                @endif
                                This is {{ status_name($manga->status) }} {{ type_name($manga->type) }} was released
                                on {{ $manga->released }}.
                                @if(!empty($genres))
                                    {{ $manga->name }} is about {{ implode(', ', $genres) }}.</p>
                            @endif
                        </div>
                        <div class="related-manga wleft">
                            <h4 class="manga-panel-title"><i class="icofont-star-shape"></i> YOU MAY ALSO LIKE</h4>
                            <div class="related-items">
                                @foreach( (new \Models\Manga)->RelatedManga(4) as $manga)

                                    <div class="item">
                                        <div class="rlbsx">
                                            <div class="thumb">
                                                <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                   title="{{ $manga->name }}">
                                                    <img data-src="{{ $manga->cover }}"
                                                         src="{{ $manga->cover }}"
                                                         alt="{{ $manga->name }}">
                                                </a>
                                            </div>
                                            <div class="bigor">
                                                <h5 class="tt">
                                                    <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                                       title="{{ $manga->name }}">
                                                        {{ $manga->name }} </a>
                                                </h5>
                                                <div class="listsb-chapter">
                                                    @foreach(array_slice(get_manga_data('chapters', $manga->id, []), 0 , 2) as $chapter)
                                                        <div class="chapter-item wleft">
                                                    <span class="chapter">
                                                        <a href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapter->slug, 'c_id' => $chapter->id ]) }}"
                                                           class="btn-link"> {{ $chapter->name }} </a>
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

                $.get('/ajax/image/list/chap/' + chapter_id + '?mode=vertical&quality=high', function (res) {
                    // var data = jQuery.parseJSON(res)

                    if (res.status === true) {
                        $(".read-content").html(res.html)
                    }
                })
            });
        </script>

        <script type="text/javascript">
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
    </div>

@stop