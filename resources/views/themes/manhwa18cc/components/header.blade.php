<div class="search-manga wleft tcenter" style="display: none;">
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
                    <a class="wleft" ng-click="readManga(data.id,data.slug)" ng-bind-html="data.name"
                       href="javascript:(0)"></a>
                </li>
            </ul>
            <div ng-if="loading" class="search-loading">
                <img src="/manhwa18cc/images/images-search-loading.gif" alt="loading...">
            </div>
        </div>
    </div>
</div>

<div class="header-manga pc-header wleft">
    <div class="header-top wleft">
        <div class="centernav">
            <div class="logo">
                <a title="Read Webtoons and Korean Manhwa in English for Free" href="{{ url("home") }}">
                    <img src="/manhwa18cc/images/images-manhwa18.png"
                         alt="Read Webtoons and Korean Manhwa in English for Free">
                </a>
            </div>
            <div class="top-menu">
                <div class="left-menu">
                    <ul>
                        <li class="menu-item">
                            <a href="{{ url("home") }}" title="Read Webtoons and Korean Manhwa in English for Free">
                                <i class="icofont-home"></i> {{ L::_("HOME") }}
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ url("latest-updated") }}"
                               title="Browser all Webtoons and Korean Manhwa">{{ L::_("All Webtoons") }}</a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ url("search", null, ['keyword' => 'raw']) }}"
                               title="Premium Webtoons Raw, Manhwa Raw">{{ L::_("Raw") }}</a>
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
    <div class="header-bottom wleft">
        <div class="centernav">
            <ul>
                <li>
                    <a href="{{ url("completed") }}"
                       title="Completed Webtoons, Korean Manhwa">{{ L::_("Completed") }}</a>
                </li>
                <li class="dropdownmenu">
                    <a href="#" title="Manga List - Genres: All">
                        {{ L::_("Genres") }} <i class="icofont-caret-right"></i>
                    </a>
                </li>
                <div class="sub-menu" style="display: none;">
                    <ul>
                        @foreach(Models\Taxonomy::GetListGenres() as $genre)
                            <li>
                                <a href="{{ url('genres', ['genres' => $genre->slug]) }}"
                                   title="{{ $genre->name }}">{{ $genre->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </ul>
            @include("themes.manhwa18cc.components.user-block")
        </div>
    </div>
</div>

<div class="header-manga mb-header wleft">
    <div class="top-header">
        <div class="menu-ico">
            <i class="icofont-navigation-menu open-menu"></i>
            <i class="icofont-close close-menu" style="display: none;"></i>
        </div>
        <div class="logo">
            <a title="Read Webtoons and Korean Manhwa in English for Free" href="{{ url("home") }}">
                <img src="/manhwa18cc/images/images-manhwa18.png"
                     alt="Read Webtoons and Korean Manhwa in English for Free">
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
                    <a href="{{ url('home') }}" title="Read Webtoons and Korean Manhwa in English for Free"><i
                                class="icofont-home"></i> {{ L::_("Home") }}</a>
                </li>
                <li>
                    <a href="{{ url("latest-updated") }}"
                       title="Browser all Webtoons and Korean Manhwa">{{ L::_("All Webtoons") }}</a>
                </li>
                <li>
                    <a href="{{ url("search", null, ['keyword' => 'raw']) }}" title="Premium Webtoons Raw, Manhwa Raw">Raw</a>
                </li>
                <li class="dropdownmenumb">
                    <a href="#" title="Manga List - Genres: All">
                        {{ L::_("Genres") }} <i class="icofont-caret-right"></i>
                    </a>
                </li>
                <div class="sub-menumb" style="display: none;">
                    <ul>
                        @foreach(Models\Taxonomy::GetListGenres() as $genre)
                            <li>
                                <a href="{{ url('genres', ['genres' => $genre->slug]) }}" title="{{ $genre->name }}"><i
                                            class="icofont-caret-right"></i>{{ $genre->name }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <li>
                    <a href="{{ url("completed") }}"
                       title="Completed Webtoons, Korean Manhwa">{{ L::_("Completed") }}</a>
                </li>
            </ul>
            @include("themes.manhwa18cc.components.user-block")
        </div>
    </div>
</div>