@extends('themes.manga18fx.layouts.full')

<?php
include(ROOT_PATH . '/resources/views/includes/manga.php');
$manga->rating_score = floor(($manga->rating_score / 2) * 2) / 2;
?>

@section('title', $metaConf['manga_title'])
@section('description', $metaConf['manga_description'] )
@section('url', $manga_url)
@section('image', $manga->cover)

@include('ads.banner-ngang')
@include('ads.banner-sidebar')

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
    <div class="manga-content ">
        <script type="text/javascript" src="/manga18fx/js/js-jquery.cookie.js"></script>

        @include("themes.manga18fx.components.manga.profile")

        <div class="centernav">
            <div class="site-body">
                @if((new \Models\User)->hasPermission(['all', 'manga']))
                    <style>
                        .manage-menu .btn {
                            background: #191A19;
                            font-weight: 600;
                            color: #fff;
                        }

                    </style>
                    <div class="mb-4 manage-menu">
                        <a href="{{ url("admin.chapter-add", ['m_id' => $manga->id]) }}" class="btn mr-2"> <i class="icofont-upload"></i> Thêm chương</a>
                        <a href="{{ url("admin.manga-edit", ['m_id' => $manga->id]) }}" class="btn"> <i class="icofont-edit"></i> Sửa truyện</a>

                    </div>
                @endif

                @hasSection('banner-ngang')
                    <div class="mb-3">
                        @yield('banner-ngang')
                    </div>
                @endif
                <div class="content-manga-left">
                    <div class="panel-story-description">
                        <h2 class="manga-panel-title "><i class="icofont-read-book"></i> {{ L::_("Summary") }}
                        </h2>
                        <div class="dsct">
                            @if(!empty(($manga->description)))
                                <p>{{ $manga->description }}</p>
                            @else
                                <p>
                                    {{ $metaConf['manga_description'] }}
                                </p>
                            @endif
                        </div>
                        @hasSection('banner-ngang')
                            @yield('banner-ngang')
                        @endif
                    </div>
                    <div class="panel-manga-chapter " id="chapterlist">
                        <h2 class="manga-panel-title "><i class="icofont-flash"></i> {{ L::_("Latest Chapter Releases") }}</h2>
                        <ul class="row-content-chapter ">
                            @foreach($chapters as $chapter)
                                <li class="a-h col-sm-12 row">
                                    <a class="chapter-name text-nowrap col-sm-6" data-chapter-id="{{ $chapter->id }}"
                                       href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_id' => $chapter->id, 'c_slug' => $chapter->slug]) }}"
                                       title="{{ $manga->name }} {{ $chapter->name }}">{{ $chapter->name }}</a>                                    
                                    <span class="chapter-time text-nowrap col-sm-3">{{ time_convert($chapter->last_update) }}</span>
                                    <span class="view col-sm-2" style="color: #fff;"><i class="icofont-eye-open"></i> {{ $chapter->views }}</span>
                                    @if ($chapter->is_lock)
                                        @if (isset($chapter->is_unlocked) && $chapter->is_unlocked)
                                            <span class="view col-sm-1" style="color: #fff;">                                        
                                                <a id="unlock-chapter-{{$chapter->id}}" data-chapter-id="{{ $chapter->id }}" title="{{ $manga->name }} {{ $chapter->name }}"><i class="icofont-ui-unlock"></i></a>
                                            </span>
                                        @else
                                            <span class="view col-sm-1" style="color: #fff;">                                        
                                                <a id="unlock-chapter-{{$chapter->id}}" data-chapter-id="{{ $chapter->id }}" title="{{ $manga->name }} {{ $chapter->name }}" onclick="modalUnlockChapter('{{ $chapter->id }}','{{ $chapter->id }}')"><i class="icofont-ui-lock"></i></a>
                                            </span>
                                        @endif                                        
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <div class="chapter-readmore  c-chapter-readmore">
                            <span style="display: inline;">{{ L::_("Show more") }} <i class="icofont-simple-down"></i></span>
                        </div>
                    </div>
                    @include('themes.manga18fx.components.comment')
                     @hasSection('banner-ngang')
                            @yield('banner-ngang')
                        @endif
                    <div class="manga-tags ">
                        <h5>Tags:</h5>
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
                    <div class="related-manga ">
                        <h4 class="manga-panel-title">
                            <i class="icofont-favourite"></i>
                            {{ L::_("YOU MAY ALSO LIKE") }}
                        </h4>
                        <div class="related-items">
                            @foreach( (new \Models\Manga)->RelatedManga(4) as $manga)
                                <div class="item">
                                    <div class="rlbsx">
                                        <div class="thumb">
                                            <a href="{{ url('manga', ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                               title="{{ $manga->name }}">
                                                <img data-src="{{ $manga->cover }}"
                                                     src="{{ $manga->cover }}" alt="{{ $manga->name }}">
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
                                                           title="{{ $manga->name }} {{ $chapter->name }}"> {{ $chapter->name }}@if($chapter->name_extend) - {{ $chapter->name_extend }} @endif</a>
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
                <div class="sidebar">
                    @include("themes.manga18fx.components.popular-sidebar")

                    @hasSection('banner-sidebar')
                        @yield('banner-sidebar')
                    @endif
                </div>
            </div>
        </div>


    </div>

@stop
<div id="modal-pos"></div>
@section('js-body')
    <style>
        .panel-manga-chapter ul li a.isread, .panel-manga-chapter ul li a:visited {
            color: #c1c1c1;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.chapter-readmore span').click(function () {
                $('.panel-manga-chapter ul').css('max-height', 'fit-content');
                $(this).css('display', 'none');
            });

            $(".chapter-name").each(function () {
                var chapid = $(this).data('chapter-id');

                if (chapid) {
                    if (localStorage.getItem('isread_' + chapid)) {
                        $(this).addClass('isread');
                    }
                }
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

        function modalUnlockChapter(mangaId,chapterId){        
            
            if(!isLoggedIn) {
                $(document).Toasts('create', {
                                   title: 'Thông báo',
                                   class: 'bg-danger',
                                   autohide: true,
                                   delay: 1000,
                                   body: 'Bạn chưa đăng nhập'
                               })
                return;
            }

               $.get('/api/unlock-chapter-template/' + chapterId, function (data) {

                   OpenAjaxModal(data);
                   
                   $('#frmUnlockChapter').on('submit', function(e) {
                       
                        e.preventDefault(); // Ngăn chặn hành vi submit mặc định

                       // Lấy URL từ thuộc tính action của form
                       var formAction = $(this).attr('action');
                       // Lấy dữ liệu từ form
                       var formData = $(this).serialize(); // Serialize các giá trị của form
                       // Gửi dữ liệu qua AJAX
                       $.ajax({
                           url: formAction, // Sử dụng URL từ action của form
                           type: 'POST', // Phương thức gửi
                           data: formData, // Dữ liệu cần gửi
                           success: function(response) {
                               // Xử lý phản hồi từ server
                               if(response.status!=='ok'){
                                    toastr.warning(response.msg);
                               }else{
                                    toastr.success(response.msg); 
                                    let idUnlockChapter='unlock-chapter-'+chapterId;    
                                    $(`#${idUnlockChapter}`).html('<i class="icofont-ui-unlock"></i>');
                                    $(`#${idUnlockChapter}`).removeAttr('onclick');
                               }     
                               $('#ajax-modal').modal('hide');
                           },
                           error: function(xhr, status, error) {
                               // Xử lý nếu có lỗi xảy ra
                               console.log("ERROR : ", error);
                               toastr.warning(error);
                           }
                       });
                   });
               });
           }

           function OpenAjaxModal(html){
                let modalPos = $('#modal-pos');
                modalPos.empty();
                modalPos.html(html)
                $("#ajax-modal").modal('show');
            }


    </script>
@stop