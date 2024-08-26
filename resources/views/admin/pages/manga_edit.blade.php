@extends('admin.layout')

@section('css_plugins')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="/admin/css/dataTables.bootstrap4.min.css"/>
    
    <style>
        .cover-preview {
            text-align: -webkit-center;
        }

        .cover-preview img {
            height: 250px;
            /* width: 100%; */
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
                        <h1>Chi tiết <a
                                    href="{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}">{{ $manga->name }}</a>
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Admin</a></li>
                            <li class="breadcrumb-item active"><a
                                        href="{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}">{{ $manga->name }}</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content" style="min-height: 1000px;">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#editmanga" data-toggle="tab">Chỉnh Sửa
                                Truyện</a></li>
                        <li class="nav-item"><a class="nav-link" id="showdschuong" href="#dschuong" data-toggle="tab">Danh
                                Sách Chương</a></li>
                        <li class="nav-item"><a class="nav-link" id="showdschuong" href="#dscomment" data-toggle="tab">Bình
                                Luận</a></li>
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item mt-1">
                                <a class="btn btn-sm btn-success"
                                   href="{{ url('admin.chapter-add', ['m_id' => $manga->id]) }}"><i
                                            class="fas fa-plus"></i> Thêm Chương</a>
                            </li>

                        </ul>

                    </ul>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="editmanga">
                            <form id="my-form" action="{{ url('api.manga-edit', ['m_id' => $manga->id]) }}"
                                  method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class=" col-lg-9">
                                        <div class="form-group">
                                            <label for="inputName">Tên truyện</label>
                                            <input type="text" name="name" id="inputName" class="form-control"
                                                   value="{{ $manga->name }}" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Đường dẫn</label>
                                            <input type="text" name="slug" id="inputName" class="form-control"
                                                   value="{{ $manga->slug }}" autocomplete="off">
                                            <small>bỏ trống sẽ tự động tạo</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputOtherName">Tên khác</label>
                                            <input type="text" name="other_name" id="inputOtherName"
                                                   class="form-control" value="{{ $manga->other_name }}"
                                                   autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Mô tả</label>
                                            <textarea name="description" id="inputDescription" class="form-control"
                                                      rows="4"
                                                      autocomplete="off">{{ $manga->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Tình trạng</label>
                                            <select name="status" id="inputStatus" class="form-control custom-select">
                                                @foreach(allStatus() as $slug => $status)
                                                    <option {{ $manga->status == $slug ? 'selected="selected"': '' }} value="{{ $slug }}">{{ $status }}</option>
                                                @endforeach;
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">Loại Truyện</label>
                                            <select name="type" class="form-control custom-select">
                                                @foreach(allComicType() as $slug => $type)
                                                    <option {{ $manga->type == $slug ? 'selected="selected"': '' }} value="{{ $slug }}">{{ $type }}</option>
                                                @endforeach;
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputClientCompany">Năm Phát Hành</label>
                                            <input type="number" name="released" class="form-control"
                                                   value="{{ $manga->released }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputClientCompany">Views</label>
                                            <input type="number" name="views" class="form-control"
                                                   value="{{ $manga->views }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputClientCompany">Quốc Gia</label>
                                            <input type="text" name="country" class="form-control"
                                                   value="{{ $manga->country }}">
                                        </div>
                                        <div class="form-group">
                                            <div class="select2-purple">
                                                <label for="inputProjectLeader">Thể loại</label>
                                                <select name="genres[]" class="select2" multiple="multiple"
                                                        data-type="genres"
                                                        data-dropdown-css-class="select2-purple" style="width: 100%;">
                                                    @foreach(get_manga_data('genres', $manga->id, []) as $genre)
                                                        <option selected="selected">{{ $genre->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputProjectLeader">Tác giả</label>
                                            <select name="authors[]" class="select2" multiple="multiple"
                                                    data-type="authors"
                                                    data-limit="10" style="width: 100%;">
                                                @foreach(get_manga_data('authors', $manga->id, []) as $author)
                                                    <option selected="selected">{{ $author->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputProjectLeader">Nhóm dịch</label>
                                            <select name="artists[]" class="select2" multiple="multiple"
                                                    data-type="artists"
                                                    data-limit="10" style="width: 100%;">
                                                @foreach(get_manga_data('artists', $manga->id, []) as $artist)
                                                    <option selected="selected">{{ $artist->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputProjectLeader">Tags</label>
                                            <select name="tags[]" class="select2" multiple="multiple" data-type="tags"
                                                    data-limit="10" style="width: 100%;">
                                                @foreach(get_manga_data('tags', $manga->id, []) as $tag)
                                                    <option selected="selected">{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>                                        <!-- /.card -->
                                    </div>
                                    <div class=" col-lg-3">
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Ảnh đại diện</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse"
                                                            title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div style="text-align: -webkit-center;" class="card-body">
                                                <div class="col-12 col-sm-6 col-lg-12">
                                                    <div class="form-group cover-preview">
                                                        <img id="cover-preview"
                                                             src="{{ $manga->cover ?? "https://lkdtt.com/storage/images/raw/no-cover.png" }}"/>
                                                        <input accept="image/*" id="btn-upload-cover" type="file"
                                                               name="cover" onchange="loadFile(event)" hidden/>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-6 col-lg-12">
                                                    <div class="row">
                                                        <input type="submit" data-hidden="1"
                                                               class="btnSubmit btn btn-secondary btn-block"
                                                               value="Lưu nháp"/>
                                                        <input type="submit" data-hidden="0"
                                                               class="btnSubmit btn btn-success btn-block"
                                                               value="Đăng truyện"/>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>


                                        <!-- /.card -->
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="dschuong">
                            <div class="row">
                                <div class="col-12">
                                    <div class=" table-responsive">
                                        <table id="chapters" class="table ">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tên Chương</th>
                                                <th>Tình Trạng</th>
                                                <th>Cập Nhật</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($chapters as $chapter)
                                                <tr>
                                                    <td>{{ $chapter->id }}</td>
                                                    <td>{{ $chapter->name }}</td>
                                                    <td>{{ $chapter->hidden  == 0 ? "Công khai" : "Nháp" }}</td>
                                                    <td>{{ timeago($chapter->last_update) }}</td>
                                                    <td class="text-right py-0 align-middle">
                                                        <div class="btn-group btn-group-sm">                                                   
                                                            <button class="btn btn-warning" onclick="modalLockChapter('{{ $chapter->manga_id }}','{{ $chapter->id }}')"><i class="fas fa-lock"></i> Khóa
                                                            @if ($chapter->is_lock)
                                                                <span id="badge-price-{{ $chapter->id }}" class="badge badge-light">{{ $chapter->price }}</span>
                                                            @endif                                                            
                                                            </button>
                                                            <a href="{{ url('admin.chapter-edit', ['c_id' => $chapter->id]) }}" class="btn btn-info"><i class="fas fa-edit"></i> Sửa</a>
                                                            <a href="{{ url('api.delete-chapter', ['c_id' => $chapter->id]) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Xoá</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="dscomment">

                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.card-body -->
            </div>


        </section>
    </div>
@stop

@section('javascript_plugins')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
            integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/admin/js/jquery.dataTables.min.js"></script>
    <script src="/admin/js/dataTables.bootstrap4.min.js"></script>
    <script src="/admin/js/dataTables.responsive.min.js"></script>
    <script src="/admin/js/responsive.bootstrap4.min.js"></script>

    

    <script type="text/javascript">
        if (location.hash) {
            $('a[href=\'' + location.hash + '\']').tab('show');
        }
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }

        $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
            e.preventDefault()
            var tab_name = this.getAttribute('href')
            if (history.pushState) {
                history.pushState(null, null, tab_name)
            } else {
                location.hash = tab_name
            }
            localStorage.setItem('activeTab', tab_name)

            $(this).tab('show');
            return false;
        });

        $(window).on('popstate', function () {
            var anchor = location.hash ||
                $('a[data-toggle=\'tab\']').first().attr('href');
            $('a[href=\'' + anchor + '\']').tab('show');
        });

        var Tabel = $("#chapters").DataTable({
            // "responsive": true,
            "lengthChange": false,
            "autoWidth": true,
            "pageLength": 25,
            "lengthMenu": [[10, 25, 50, 100, 500], [10, 25, 50, 100, 500]],
            "processing": true,
            "order": [[0, "desc"]],
            "columnDefs": [
                {
                    "targets": [1, 2, 3, 4],
                    "orderable": false
                }
            ]
        })

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

        function modalLockChapter(mangaId,chapterId){
            $.get('/api/lock-chapter-template/' + chapterId, function (data) {
                OpenAjaxModal(data);
                
                $('#frmLockChapter').on('submit', function(e) {
                    e.preventDefault(); // Ngăn chặn hành vi submit mặc định
                    // Lấy URL từ thuộc tính action của form
                    var formAction = $(this).attr('action');
                    // Lấy dữ liệu từ form
                    var formData = $(this).serialize(); // Serialize các giá trị của form
                    // Gửi dữ liệu qua AJAX
                    $.ajax({
                        url: formAction, // Sử dụng URL từ action của form
                        type: 'POST', // Phương thức gửi
                        data: formData, // Dữ liệu cần gửi
                        success: function(response) {
                            // Xử lý phản hồi từ server (có thể hiển thị thông báo thành công)
                            
                            $(document).Toasts('create', {
                                class: 'bg-success m-1',
                                title: 'Thông báo',
                                autohide: true,
                                delay: 1000,
                                body: response.message
                            });

                            let idspane='badge-price-'+chapterId;

                            $(`#${idspane}`).text(response.message);                            

                            $('#ajax-modal').modal('hide');     
    

                        },
                        error: function(xhr, status, error) {
                            // Xử lý nếu có lỗi xảy ra
                            console.log("ERROR : ", error);
                            $(document).Toasts('create', {
                                title: 'Có lỗi',
                                class: 'bg-danger',
                                autohide: true,
                                delay: 1000,
                                body: error
                            })
                        }
                    });
                });

            });
        }

        
    </script>
@stop
