<div class="right">
    <div class="setting-choose">
        <ul>
            <li class="wleft">
                <a href="{{ path_url('user.profile') }}">{{ L::_("Profile") }}</a>
            </li>
            <li class="wleft">
                <a href="{{ path_url("user.reading-list") }}">{{ L::_("Bookmarks") }}</a>
            </li>
        </ul>
    </div>
    <div class="sidebar">
        @include("themes.manhwa18cc.components.popular-sidebar")
    </div>
</div>