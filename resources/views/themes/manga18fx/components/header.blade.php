<div class="search-manga " style="display: none;">
    <div id="searchpc" class="header-search" ng-controller="livesearch">
        <form action="{{ url("search") }}" method="get">
            <input name="keyword" type="text" ng-model="search_query" ng-keyup="fetchData()" placeholder="Search..."
                   autocomplete="off">
            <button type="submit">
                <i class="icofont-search-1"></i>
            </button>
        </form>
        <div class="live-search-result live-pc-result" style="display: none;">
            <ul ng-if="searchData">
                <li ng-repeat="data in searchData">
                    <a class="" ng-click="readManga(data.id,data.slug)" ng-bind-html="data.name"
                       href="javascript:(0)"></a>
                </li>
            </ul>
            <div ng-if="loading" class="search-loading">
                <img src="/manga18fx/images/images-search-loading.gif" alt="loading...">
            </div>
        </div>
    </div>
</div>
<div id="zone79369797"></div>

<div class="header-manga pc-header ">
    <div class="header-top ">
        <div class="centernav">
            <div class="logo">
                <a href="{{ url("home") }}">
                    <img src="/manhwa18cc/images/2ten-min.png" alt="2TEN - Website Đọc Truyện Tranh Online">
                </a>
            </div>
            <div class="top-menu">
                <div class="left-menu">
                    <ul>
                        <li class="menu-item">
                            <a href="{{ url("home") }}" >
                                <i class="icofont-home"></i> {{ L::_("Home") }}
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ url("manga_list") }}">{{ L::_("All Manga") }}</a>
                        </li>
                        <li class="menu-item">
                            <a id="bookmark-href" href="{{ url("user.reading-list") }}">{{ L::_("Bookmark") }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="https://forms.gle/ikkSzdSoLZA2VeGZA">Yêu cầu truyện</a>
                        </li>
                        <li class="menu-item">
                            <a  target="_blank" href="https://2ten.net">2TEN</a>
                        </li>                    
                    </ul>
                </div>
                <div class="right-menu">
                    <a class="open-search-main-menu search-ico" href="javascript:(0)">
                        <i class="icofont-search-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom ">
        <div class="centernav">
            <ul>
                @if((new \Models\User)->hasPermission(['all', 'manga']))
                    <li>
                        <a class="text-danger" href="{{ path_url('admin') }}"><i class="icofont-speed-meter"></i> {{ L::_("Admin") }}</a>
                    </li>
                @endif
                <li>
                    <a href="{{ path_url("manga.history") }}" class="text-danger" title="{{ L::_("History") }}"><i class="icofont-history"></i> {{ L::_("History") }}</a>
                </li>
                <li>
                    <a href="{{ url("completed") }}" title="{{ L::_("Completed") }}"> {{ L::_("Completed") }}</a>
                </li>
                <li>
                    <a href="{{ url("most-viewed") }}" title="{{ L::_("Most Viewed") }}"> {{ L::_("Most Viewed") }}</a>
                </li>
                <li class="dropdownmenu">
                    <a href="#" title="{{ L::_("Genres") }}">{{ L::_("Genres") }} <i class="icofont-caret-right"></i></a>
                </li>
                <div class="sub-menu" style="display: none;">
                    <ul>
                        @foreach(Models\Taxonomy::GetListGenres() as $genre)
                            <li>
                                <a href="{{ url('genres', ['genres' => $genre->slug]) }}" title="{{ $genre->name }}">{{ $genre->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </ul>
            @include("themes.manga18fx.components.user-block")
        </div>
    </div>
</div>

<div class="header-manga mb-header ">
    <div class="top-header">
        <div class="menu-ico">
            <i class="icofont-navigation-menu open-menu"></i>
            <i class="icofont-close close-menu" style="display: none;"></i>
        </div>
        <div class="logo">
            <a href="{{ url("home") }}">
                <img src="/manhwa18cc/images/2ten-min.png">
            </a>
        </div>
        <div class="search-ico">
            <i class="icofont-search-1 open-search" style="display: block;"></i>
            <i class="icofont-close close-search" style="display: none;"></i>
        </div>
    </div>
    <div class="under-header">
        <div class="header-menu" style="display: none;">
            <ul>
                <li>
                    <a href="{{ url('home') }}" title="{{ L::_("Home") }}"><i class="icofont-home"></i> {{ L::_("Home") }}</a>
                </li>
                <li>
                    <a href="{{ url("manga_list") }}" title="{{ L::_("All Manga") }}">{{ L::_("All Manga") }}</a>
                </li>
                <li>
                    <a href="{{ url("user.reading-list") }}" title="{{ L::_("Bookmark") }}">{{ L::_("Bookmark") }}</a>
                </li>
                <li>
                    <a class="text-danger" href="{{ url("manga.history") }}" title="{{ L::_("History") }}">{{ L::_("History") }}</a>
                </li>
                <li class="dropdownmenumb">
                    <a href="#" title="Manga List - Genres: All">{{ L::_("Genres") }} <i class="icofont-caret-right"></i></a>
                </li>
                <div class="sub-menumb" style="display: none;">
                    <ul>
                        @foreach(Models\Taxonomy::GetListGenres() as $genre)
                            <li>
                                <a href="{{ url('genres', ['genres' => $genre->slug]) }}" title="{{ $genre->name }}"><i class="icofont-caret-right"></i>{{ $genre->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <li>
                    <a href="{{ url("completed") }}" title="{{ L::_("Completed") }}">{{ L::_("Completed") }}</a>
                </li>
                <li class="menu-item">
                    <a href="https://forms.gle/ikkSzdSoLZA2VeGZA">Yêu cầu truyện</a>
                </li> 
            </ul>
            @include("themes.manga18fx.components.user-block")
        </div>
    </div>
    <div class="notifications-header">
        <div class="bixbox">
            <a href="https://2ten.net"><i class="icofont-flash"></i> 2TEN</a>
        </div>        
    </div>
</div>