@extends('admin.layout')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh Sách Báo Lỗi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Admin</a></li>
                            <li class="breadcrumb-item active">Danh Sách Báo Lỗi</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mt-1"><i class="fas fa-list"></i> Danh sách báo lỗi</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">


                                    @if($reported)
                                        <div class="col-12 alert alert-warning">Khi xoá báo lỗi, các trùng lặp sẽ bị xoá theo</div>
                                        @foreach($reported as $report_item)
                                            @if($report_item->type === 'chapter_error')
                                                <?php
                                                $data_report = json_decode($report_item->content)
                                                ?>

                                                <div class="col-12 border-bottom pt-2 pb-2">
                                                    <div class="text-bold text-info">
                                                        {{ $data_report->report_title }}
                                                        <a href="{{ url('admin.chapter-edit', ['c_id' => $report_item->reported_id]) }}"
                                                           class="ml-2 btn btn-xs btn-success">
                                                            <i class="fas fa-pen"></i></a>
                                                        <div class="btn btn-xs btn-danger delete-report"
                                                             data-id="{{ $report_item->reported_id }}">
                                                            <i class="fas fa-trash"></i></div>
                                                    </div>


                                                    <div>
                                                        <span class="text-bold"> Nội dung lỗi: </span> {{ $data_report->content }}
                                                    </div>
                                                </div>


                                            @endif

                                        @endforeach
                                    @else
                                        Không có báo lỗi

                                    @endif
                                </div>
                            </div>

                            <div class="card-footer clearfix bg-white">
                                <ul class="pagination m-0">
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
                                               href="{{ url(null, ['page' => $page + 2 ]) }}">{{ $page + 2 }}</a>
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