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
                                            class="fas fa-list"></i> Danh sách nhóm dịch</h3>
                                <div class="card-tools">
                                    <button onclick="addGroup()" class="btn btn-sm btn-success"><i
                                                class="fas fa-plus"></i> Thêm
                                    </button>
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
                                                    <th class="text-blue">Thông Tin</th>
                                                    <th width="180px" class="text-center">Hành Động</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($datas as $item)
                                                    <?php
                                                    $item->metadata = json_decode($item->metadata);
                                                    ?>
                                                    <tr class="group-item" data-id="{{ $item->id }}" data-user-id="{{ $item->user_id }}"
                                                        data-name="{{ $item->name }}" data-type="{{ $item->type }}">
                                                        <td width="30px" class="text-center align-middle">
                                                            <input
                                                                    type="checkbox"
                                                                    class="choose_box">
                                                        </td>
                                                        <td>
                                                            <div class="w-100"><strong><span
                                                                            class="text-info">{{ $item->name }}</span></strong>
                                                                @if($item->metadata->name_group)
                                                                    <span class="ml-2 mb-1 badge badge-info">{{ $item->metadata->name_group }}</span>
                                                                @endif                                                            </div>

                                                            <i class="w-100">
                                                                <a style="font-size: 14px" class="link-highlight " href="{{ $item->metadata->url_produce }}"> {{ $item->metadata->url_produce }} </a>
                                                            </i>


                                                        </td>
                                                        <td class="text-center" width="180px">
                                                            <button type="button"
                                                                    class="btn btn-warning btn-sm accept-request">
                                                                Duyệt
                                                            </button>


                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm group-remove">
                                                                Từ Chối
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
                                        <a class="page-link " href="{{ url(null, ['page' => $page - 1]) }}">«</a>
                                    </li>
                                    @if($page > 1)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, ['page' => $page - 1]) }}">{{ $page - 1 }}</a>
                                        </li>
                                    @endif
                                    <li class="page-item active">
                                        <a class="page-link" href="#">{{ $page }}</a>
                                    </li>
                                    @if($page + 1 <= $total_page)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, ['page' => $page + 1]) }}">{{ $page + 1 }}</a>
                                        </li>
                                    @endif

                                    @if($page + 2 <= $total_page)
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="{{ url(null, ['page' => $page + 2]) }}">{{ $page + 2 }}</a>
                                        </li>
                                    @endif

                                    <li class="page-item {{ $page >= $total_page ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url(null, ['page' => $page + 1]) }}">»</a>
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

@stop

@section('javascript_plugins')
    <script>


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

        $(document).on('click', '.accept-request', function () {
              var $parents = $(this).parents('.group-item');


            $.post('/api/accept-request', {
                type: $parents.data('type'),
                id: $parents.data('id'),
                user_id: $parents.data('user-id')
            }, function (data) {
                location.reload()
            });
        });

    </script>


@stop
