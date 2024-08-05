@if(!is_login())
    <div class="user-block tright" ng-controller="userFunction">
        <div class="guest-option">
            <a href="{{ url("user.login") }}">{{ L::_("Sign In") }}</a>
            <a href="{{ url("user.register") }}">{{ L::_("Sign Up") }}</a>
        </div>
    </div>
@else
    <div class="user-block tright ng-scope" ng-controller="userFunction">
        <div class="box-user-options">
            <div class="c-user_avatar">
                <a href="{{ url("user.reading-list") }}">
                    <div class="c-user_avatar-image">
                        <img alt="" src="{{ userget()->avatar_url }}" class="avatar" height="50" width="50"
                             style="margin-top: -5px;">
                    </div>
                    <div class="displayname tleft">
                        <span class="name tleft">Hi, {{ userget()->name }}</span>
                    </div>
                </a>
            </div>
            <div class="user-logout">
                <a href="{{ url("logout") }}" data-method="get">
                    <i class="icofont-ui-power"></i>
                </a>
            </div>
        </div>
    </div>

@endif