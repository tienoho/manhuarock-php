@extends('admin.layout')

@section('css_plugins')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .cover-preview {
            text-align: -webkit-center;
        }

        .cover-preview img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }
    </style>
@stop

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Thêm Truyện Mới</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Admin</a></li>
                            <li class="breadcrumb-item active">Thêm Truyện Mới</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content" style="min-height: 1000px;">
            <form id="my-form" action="{{ url('api.manga-add') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class=" col-lg-9">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Thông Tin</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName">Tên truyện</label>
                                    <input type="text" name="name" id="inputName" class="form-control"
                                           autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="inputName">Đường dẫn</label>
                                    <input type="text" name="slug" id="inputName" class="form-control"
                                           autocomplete="off">
                                    <small>bỏ trống sẽ tự động tạo</small>
                                </div>
                                <div class="form-group">
                                    <label for="inputOtherName">Tên khác</label>
                                    <input type="text" name="other_name" id="inputOtherName" class="form-control"
                                           autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Mô tả</label>
                                    <textarea name="description" id="inputDescription" class="form-control" rows="4"
                                              autocomplete="off"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Tình trạng</label>
                                    <select name="status" id="inputStatus" class="form-control custom-select">
                                        <option selected="" disabled="">Chọn một</option>
                                        @foreach(allStatus() as $slug => $status)
                                        <option value="{{ $slug }}">{{ $status }}</option>
                                        @endforeach;
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">Loại Truyện</label>
                                    <select name="type" id="inputStatus" class="form-control custom-select">
                                        <option selected="" disabled="">Chọn một</option>
                                        @foreach(allComicType() as $slug => $type)
                                        <option value="{{ $slug }}">{{ $type }}</option>
                                        @endforeach;
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputClientCompany">Năm phát hành</label>
                                    <input type="number" name="released" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="inputClientCompany">Quốc Gia</label>
                                    <input type="text" name="country" class="form-control">
                                </div>

                                <div class="form-group">
                                    <div class="select2-purple">
                                        <label for="inputProjectLeader">Thể loại</label>
                                        <select name="genres[]" class="select2" multiple="multiple" data-type="genres"
                                                data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputProjectLeader">Tác giả</label>
                                    <select name="authors[]" class="select2" multiple="multiple" data-type="authors"
                                            data-limit="10" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label for="inputProjectLeader">Nhóm dịch</label>
                                    <select name="artists[]" class="select2" multiple="multiple" data-type="artists"
                                            data-limit="10" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label for="inputProjectLeader">Tag</label>
                                    <select name="tags[]" class="select2" multiple="multiple" data-type="tags"
                                            data-limit="10" style="width: 100%;"></select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class=" col-lg-3">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Ảnh đại diện</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                            title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="text-align: -webkit-center;" class="card-body">
                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="form-group cover-preview">
                                        <img id="cover-preview"
                                             src="https://lkdtt.com/storage/images/raw/no-cover.png"/>
                                        <input accept="image/*" id="btn-upload-cover" type="file" name="cover" onchange="loadFile(event)" hidden/>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 col-lg-12">
                                    <div class="row">
                                        <input type="submit" data-hidden="1" class="btnSubmit btn btn-secondary btn-block" value="Lưu nháp"/>
                                        <input type="submit" data-hidden="0" class="btnSubmit btn btn-success btn-block" value="Đăng truyện"/>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </form>


        </section>
    </div>
@stop

@section('javascript_plugins')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $("#cover-preview").on('click', function (e) {
                $("#btn-upload-cover").click();
            });


            $(".btnSubmit").click(function (event) {
                //stop submit the form, we will post it manually.
                event.preventDefault();

                // Get form
                const form = $('#my-form');

                // FormData object
                const data = new FormData(form[0]);
                const url = $(form).attr('action')
                // If you want to add an extra field for the FormData
                data.append("hidden", $(this).data('hidden'));

                // disabled the submit button
                $("#btnSubmit").prop("disabled", true);

                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (data) {
                        console.log("SUCCESS : ", data);
                        $(document).Toasts('create', {
                            title: 'Thông báo',
                            class: 'bg-success',
                            autohide: true,
                            delay: 1000,
                            body: data.message
                        })
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                        $(document).Toasts('create', {
                            title: 'Có lỗi',
                            class: 'bg-danger',
                            autohide: true,
                            delay: 1000,
                            body: e.responseJSON.message
                        })
                        $("#btnSubmit").prop("disabled", false);
                    }
                });
            });
        });

        const loadFile = function (event) {
            let output = document.getElementById('cover-preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        $('.select2').select2({
            ajax: {
                url: '/api/search-taxonomy',
                data: function (params) {
                    // Query parameters will be ?search=[term]&type=public
                    return {
                        search: params.term,
                        taxonomy: $(this).data("type"),
                        limit: $(this).data("limit") ?? null,
                    };
                },
                processResults: function (data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.name,
                            }
                        })
                    }
                }
            },
            tags: true,
            tokenSeparators: [','],
            createTag: function (params) {
                let term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                }
            }
        });


    </script>
@stop
