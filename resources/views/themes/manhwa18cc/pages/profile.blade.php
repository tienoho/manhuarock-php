@extends('themes.manhwa18cc.layouts.full')
@section('title', 'Trang Cá Nhân')

@section('content')
    <div class="manga-content wleft">
        <div class="user-content">
            <div class="centernav">
                <div class="c-breadcrumb-wrapper">
                    <div class="c-breadcrumb">
                        <ol class="breadcrumb">
                            <li>
                                <a href="/" title="Read Manga Online">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ url() }}" class="active">
                                    {{ L::_("Profile") }}
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="user-setting wleft">
                    <div class="left">
                        <div class="user-settings wleft ng-scope" ng-controller="userSetting">
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        Change Your Display name
                                    </h3>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label">{{ L::_("Current Display Name") }}</label>
                                    <div class="form-input">
                                        <!-- ngIf: !validate --><span class="show ng-scope"
                                                                      ng-if="!validate">{{ userget()->name }}</span>
                                        <!-- end ngIf: !validate -->
                                        <!-- ngIf: validate -->
                                    </div>
                                </div>
                                <form ng-submit="changeDisplay(form)" class="ng-pristine ng-valid">
                                    <div class="form-items wleft">
                                        <label class="form-label">New Display name</label>
                                        <div class="form-input">
                                            <input type="text" placeholder="Display Name" ng-model="form.displayname"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                            <div class="message wleft">
                                                <!-- ngIf: validate -->
                                                <!-- ngIf: !validate --><p ng-if="!validate"
                                                                           class="error ng-binding ng-scope"></p>
                                                <!-- end ngIf: !validate -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label">Submit</label>
                                        <div class="form-input">
                                            <input type="submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        Your email address
                                    </h3>
                                </div>
                                <div class="form-items wleft">
                                    <label class="form-label">Current Email</label>
                                    <div class="form-input">
                                        <span class="show">{{ userget()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-item wleft">
                                <div class="settings-title">
                                    <h3>
                                        Change Your Password
                                    </h3>
                                </div>
                                <form ng-submit="changePass(form)" class="ng-pristine ng-valid">
                                    <div class="form-items wleft">
                                        <label class="form-label">Current Password</label>
                                        <div class="form-input">
                                            <input type="password" placeholder="Current Password"
                                                   ng-model="form.current_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label">New Password</label>
                                        <div class="form-input">
                                            <input type="password" placeholder="New Password"
                                                   ng-model="form.new_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label">Comfirm Password</label>
                                        <div class="form-input">
                                            <input type="password" placeholder="Repeat Password"
                                                   ng-model="form.repeat_password"
                                                   class="ng-pristine ng-untouched ng-valid ng-empty">
                                            <div class="message wleft">
                                                <!-- ngIf: p_validate -->
                                                <!-- ngIf: !p_validate --><p ng-if="!p_validate"
                                                                             class="error ng-binding ng-scope"></p>
                                                <!-- end ngIf: !p_validate -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-items wleft">
                                        <label class="form-label">Submit</label>
                                        <div class="form-input">
                                            <input type="submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
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