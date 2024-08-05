<div class="right">
    <div class="setting-choose">
        <ul>
            @if((new \Models\User)->hasPermission(['all', 'manga']))
                <li>
                    <a href="{{ path_url('admin') }}">{{ L::_("Admin") }}</a>
                </li>
            @endif
            <li>
                <a href="{{ path_url('user.profile') }}">{{ L::_("Profile") }}</a>
            </li>
            <li>
                <a href="{{ path_url("user.reading-list") }}">{{ L::_("Bookmarks") }}</a>
            </li>
        </ul>
    </div>
    <div class="sidebar">
        @include("themes.manga18fx.components.popular-sidebar")
    </div>
</div>