@extends('themes.manhwa18cc.layouts.full')
@section('title', L::_("Bookmark"))

@section('content')
    <div class="manga-content wleft">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="{{ L::_("Read Manga Online") }}">
                                    {{ L::_("Home") }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ url("user.reading-list") }}" class="active">
                                    {{ L::_("Bookmark") }}
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="user-setting wleft ng-scope" ng-controller="userFunction">
                    <div class="left">
                        <div class="bookmark-items wleft">
                            @foreach($list_reading as $manga)
                                <div class="bookmark-item wleft">
                                    <a rel="nofollow"
                                       href="{{ url("manga", ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}"
                                       title="{{ $manga->name }}">
                                        <img class="img-loading" src="{{ $manga->cover }}"
                                             data-src="{{ $manga->cover }}" alt="Secret Class">
                                    </a>
                                    <div class="item-right">
                                        <p class="item-row-one">
                                            <a class="bookmark_remove" ng-click="removebookmark({{ $manga->id }})">
                                                <i class="icofont-close"></i>{{ L::_("Remove") }}</a>
                                            <a rel="nofollow" class="item-story-name text-nowrap color-red"
                                               href="{{ url("manga", ['m_slug' => $manga->slug, 'm_id' => $manga->id]) }}">{{ $manga->name }}</a>
                                        </p>
                                        <span class="item-title text-nowrap wleft">{{ L::_("Current") }}:
                                        <?php $chapters = get_manga_data('chapters', $manga->id); ?>
                                            @if(!empty($chapters))
                                                <a class="a-h" style="color: #079eda;" rel="nofollow"
                                                   href="{{ url('chapter', ['m_slug' => $manga->slug, 'c_slug' => $chapters[0]->slug, 'c_id' => $chapters[0]->id]) }}">{{ $chapters[0]->name }}</a></span>
                                        @else
                                            <span class="a-h" style="color: #079eda;">{{ L::_("No chapter yet") }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @include('themes.manhwa18cc.components.user.right')
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal')
@stop

@section('js-body')
@stop