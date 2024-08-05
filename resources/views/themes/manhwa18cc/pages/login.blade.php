@extends('themes.manhwa18cc.layouts.full')

@section('title', 'Đăng Nhập')

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
                                <a href="{{ url("login") }}" class="active">
                                    {{ L::_("Login") }}
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="signup-form wleft tcenter">
                    <h1>{{ L::_("Login Your Account") }}</h1>
                    <form action="/ajax/auth/login" method="POST" id="loginform" class="ng-pristine ng-valid">
                        <div class="field-panel wleft">
                            <i class="icofont-email"></i>
                            <input class="user-name" type="text" name="email"
                                   placeholder="{{ L::_("Email") }}">
                        </div>
                        <div class="field-panel wleft">
                            <i class="icofont-lock"></i>
                            <input class="pass" name="password" placeholder="{{ L::_("Password") }}" type="password">
                        </div>
                        <input name="submit_register" type="submit" id="submit_register" value="{{ L::_("SIGN IN") }}" class="submit">
                    </form>

                    <script type="text/javascript">
                        var frm = $('#loginform');

                        frm.submit(function (e) {

                            e.preventDefault();

                            $.ajax({
                                type: frm.attr('method'),
                                url: frm.attr('action'),
                                data: frm.serialize(),
                                success: function (data) {
                                    var ref = document.referrer;
                                    if(data.status){
                                        if (ref.indexOf(window.location.host)) {
                                            window.location.href = ref;
                                        } else {
                                            window.location.href = window.location.host;
                                        }
                                    }

                                },
                                error: function (data) {
                                    console.log('An error occurred.');
                                    console.log(data);
                                },
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

@stop
