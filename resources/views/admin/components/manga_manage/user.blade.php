@extends('admin.layout')

@section('css_plugins')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>

    <style>
        tr, .cursor-pointer {
            cursor: pointer;
        }

    </style>
@stop

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header position-relative"><h3 class="card-title mt-1"><i
                                            class="fas fa-list"></i> Truyện Bạn Đã Đăng</h3>
                                <div class="card-tools">
                                    <a href="{{ url('admin.manga-add') }}" class="btn btn-sm btn-success"><i
                                                class="fas fa-plus"></i> Thêm
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body ">
                                <form class="mb-2" type="POST" action="{{ url(null, ['page' => 1]) }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-default dropdown-toggle btn-flat"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                Hành Động
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item remove-all" href="#">Xoá Đã Chọn</a>
                                            </div>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" class="form-control" name="seach"
                                               value="{{ input()->value('seach') }}">

                                        <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-flat">Tìm</button>
                                    </span>
                                    </div>
                                </form>

                                <div id="table_wrapper">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <table id="table"
                                                   style=" min-width: 700px; "
                                                   class="table table-bordered table-hover dataTable dtr-inline"
                                                   role="grid" aria-describedby="table">
                                                <thead>
                                                <tr>
                                                    <th width="50px" class="text-center align-middle"><input
                                                                type="checkbox"
                                                                id="choose_all"></th>
                                                    <th class="text-blue text-center align-middle">Bìa</th>
                                                    <th class="text-blue">Thông Tin</th>
                                                    <th width="180px" class="text-center">Hành Động</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($mangas as $manga)
                                                    <tr class="group-item" data-id="{{ $manga->id }}"
                                                        data-name="{{ $manga->name }}">
                                                        <td width="30px" class="text-center align-middle">
                                                            <input
                                                                    type="checkbox"
                                                                    class="choose_box">
                                                        </td>
                                                        <td width="120px" class="text-center align-middle">
                                                            <img width="100%" src="{{ $manga->cover }}">
                                                        </td>
                                                        <td class="item-edit"
                                                            onclick="window.location = ('{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}');">
                                                            <div class="w-100">
                                                                <strong>
                                                                    <span class="text-info">{{ $manga->name }} </span>
                                                                    @if($manga->adult === 1)
                                                                        <span class="ml-1 mb-1 badge badge-danger">18+</span>
                                                                    @endif
                                                                    <span class="ml-1 mb-1 badge badge-warning">{{ $manga->views }} lượt xem</span>
                                                                </strong>
                                                            </div>
                                                            <div class="w-100">
                                                                <strong>{{ (get_manga_data('chapters', $manga->id)[0]->name ?? 'Chưa có chap') }}</strong><span
                                                                        class="ml-2 mb-1 badge badge-info">{{ timeago($manga->last_update) }}</span>
                                                            </div>
                                                            <div class="w-100">

                                                                @foreach((get_manga_data('artists', $manga->id, [])) as $artist)
                                                                    <span class="mr-2 mb-1 badge badge-primary">{{ $artist->name }}</span>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td class="text-center" width="180px">
                                                            <a href="{{ url('admin.chapter-add', ['m_id' => $manga->id]) }}"
                                                               type="button"
                                                               class="btn btn-warning btn-sm add-member">
                                                                Thêm
                                                            </a>

                                                            <a type="button"
                                                               href="{{ url('admin.manga-edit', ['m_id' => $manga->id]) }}"
                                                               class="btn btn-info btn-sm group-edit">
                                                                Sửa
                                                            </a>

                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm group-remove">
                                                                Xoá
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination m-0 float-right">
                                    <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                                        <a class="page-link " href="{{ url(null, null, ['page' => $page - 1]) }}">«</a>
                                    </li>
                                    @if($page > 1)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, null, ['page' => $page - 1]) }}">{{ $page - 1 }}</a>
                                        </li>
                                    @endif
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ $page }}</a>
                                    </li>
                                    @if($page + 1 <= $total_page)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, null,  ['page' => $page + 1]) }}">{{ $page + 1 }}</a>
                                        </li>
                                    @endif

                                    @if($page + 2 <= $total_page)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, null, ['page' => $page + 2]) }}">{{ $page + 2 }}</a>
                                        </li>
                                    @endif

                                    <li class="page-item {{ $page >= $total_page ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url(null, null, ['page' => $page + 1]) }}">»</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>


    <div class="modal fade" id="modal-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-blue">Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center mb-5 mt-5">
                        <div class="spinner-border text-blue" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button id="submit" type="button" class="btn btn-primary ">Lưu thay đổi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop

@section('javascript_plugins')
    <script>
        function getChoose() {
            var choose_list = [];

            $(".choose_box").each(function () {
                if ($(this).prop('checked') == true) {
                    choose_list.push($(this).parents('.group-item').data('id'))
                }
            })

            console.log(choose_list)

            return choose_list;
        }

        function addGroup() {
            $.get('/api/add-group', function (data) {
                $('#modal-user').modal('show');
                $('.modal-title').text("Thêm Nhóm Dịch")

                $('.modal-body').html(data)
            });
        }

        function CreateAjax(className, URL, title) {
            $(document).on('click', className, function () {
                var parents = $(this).parents(".group-item");
                var group_id = $(parents).data("id");
                var user_name = $(parents).data("name");

                // your function here
                $.get(URL + group_id, function (data) {
                    $('#modal-user').modal('show');
                    $('.modal-title').text(title + user_name)

                    $('.modal-body').html(data)
                });
            });
        }

        function RemoveUsers(taxonomy) {
            if (confirm('Xác nhận để tiếp tục hành động này!') === true) {

                $.post("/api/delete-manga", {
                    manga_ids: taxonomy
                }, function (data) {
                    // location.reload();
                })
            }
        }

        var is_choose_all = false;

        $("#choose_all").click(function () {
            $(".choose_box").each(function () {
                if (is_choose_all === false) {
                    $(this).prop('checked', true);
                    return;
                }

                $(this).prop('checked', false);
            });

            if (is_choose_all == true) {
                is_choose_all = false
                return;
            }

            is_choose_all = true
        });


        $("#submit").click(function () {
            $form = $('#modal-form');

            var Data = $form.serialize();

            $.ajax({
                url: $form.attr('action'),
                data: Data,
                type: $form.attr('type'),
                success: function (data) {
                    $('#modal-user').modal('hide');

                    $(document).Toasts('create', {
                        title: 'Thông báo',
                        class: 'bg-success',
                        autohide: true,
                        delay: 1000,
                        body: data.message
                    })
                }
            });
        });

        $(document).on('click', '.group-remove', function () {
            var parents = $(this).parents(".group-item");
            var group_id = $(parents).data("id");

            RemoveUsers(group_id);
        });

        $(document).on('click', '.remove-all', function () {
            RemoveUsers(getChoose());
        });

        CreateAjax(".add-member", "/api/add-member/", "Thêm Thành Viên Vào ");
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
            integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@stop
