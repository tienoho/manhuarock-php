@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header font-weight-bold">
                                <i class="nav-icon fas fa-tools mr-1"></i> Cài đặt website
                            </div>
                            <div class="card-body">
                                <form id="setting-form" action="{{ url() }}" method="POST">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="label-row">
                                                    Site URL
                                                </label>
                                                <div class="input-group">
                                                    <input name="site_url" type="text" class="form-control"
                                                           placeholder="Ex: https://hoimetruyen.com"
                                                           value="{{ $siteConf['site_url'] }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label class="label-row">
                                                    Số Truyện Mới Cập Nhật / Page (Home)
                                                </label>
                                                <div class="input-group">
                                                    <input name="newupdate_home" type="text" class="form-control"
                                                           placeholder="Default: 24"
                                                           value="{{ $siteConf['newupdate_home'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label class="label-row">
                                                    Số Truyện Mỗi Trang (Page Hoàn thành, xem nhiều, mới cập nhật ...)
                                                </label>
                                                <div class="input-group">
                                                    <input name="general_page" type="text" class="form-control"
                                                           placeholder="Default: 24"
                                                           value="{{ $siteConf['general_page'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label class="label-row">
                                                    Số Truyện Liên Quan ( Page manga )
                                                </label>
                                                <div class="input-group">
                                                    <input name="total_related" type="text" class="form-control"
                                                           placeholder="Default: 6"
                                                           value="{{ $siteConf['total_related'] }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label class="label-row">
                                                    Truyện Đề Cử (Sidebar)
                                                </label>
                                                <div class="input-group">
                                                    <input name="SBpopular" type="text" class="form-control"
                                                           placeholder="Default: 6"
                                                           value="{{ $siteConf['SBpopular'] }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 col-md-6">

                                            <div class="form-group">
                                                <label class="label-row">
                                                    Lịch Sử Đọc (Sidebar)
                                                </label>
                                                <div class="input-group">
                                                    <input name="SBhistory" type="text" class="form-control"
                                                           placeholder="Default: 6"
                                                           value="{{ $siteConf['SBhistory'] }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="label-row">
                                                    Tag Footer
                                                </label>
                                                <div class="input-group">
                                                    <input name="tag_footer" type="text" class="form-control"
                                                           placeholder="Ex: Truyện Tranh|Truyện Mới|Truyện 2022"
                                                           value="{{ $siteConf['tag_footer'] }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="label-row">
                                                    Google Tag Manager (Analytics)
                                                </label>
                                                <div class="input-group">
                                                    <input name="analytics_id" type="text" class="form-control"
                                                           placeholder="EX: G-GG3N4DZXXX"
                                                           value="{{ $siteConf['analytics_id'] ?? NULL }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="label-row">
                                                    FB App ID
                                                </label>
                                                <div class="input-group">
                                                    <input name="FBAppID" type="text" class="form-control"
                                                           placeholder="EX: 433270358518XXX"
                                                           value="{{ $siteConf['FBAppID'] ?? NULL }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="label-row">
                                                    Thời gian cache
                                                </label>
                                                <div class="input-group">
                                                    <input name="CacheTime" type="text" class="form-control"
                                                           placeholder="EX: 300 (5')"
                                                           value="{{ $siteConf['CacheTime'] ?? NULL }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="is_cache"
                                                           {{ ($siteConf['is_cache'] === 'on' ? 'checked' : '') }}
                                                           id="cache-control">
                                                    <label class="custom-control-label" for="cache-control">Bật
                                                        cache </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button id="setting-submit" class="btn btn-success" type="submit">Lưu
                                                    cài đặt
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header font-weight-bold">
                                <i class="nav-icon fas fa-tools mr-1"></i> Quản Lý Cache
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class=" col-12 mb-3">
                                        <button class="btn btn-danger" id="reset-cache">Làm mới Cache
                                            <span id="reset-cache-loading" style="display: none"
                                                  class="ml-1 spinner-border spinner-border-sm" role="status"
                                                  aria-hidden="true"></span>
                                        </button>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@stop
