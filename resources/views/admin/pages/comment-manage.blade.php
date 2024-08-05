@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quản lí bình luận</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if($comments)
                                @foreach($comments as $comment)
                                    <div class="col-12 border-bottom pt-2 pb-2 comment-item" mnbv
                                         data-id="{{ $comment->id }}">
                                        <div class="text-bold text-info mw-100"
                                             style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ $comment->username }}
                                            - <span class="font-weight-normal text-gray">{{ $comment->name }}</span>
                                        </div>

                                        <div class="btn btn btn-danger delete-comment float-right">
                                            <i class="fas fa-trash"></i></div>


                                        <div>
                                            <span class="text-bold"> Nội dung: </span> {{ $comment->content }}
                                        </div>
                                    </div>


                                @endforeach
                            @else
                                <div class="col-12">Không có dữ liệu</div>
                            @endif
                        </div>

                    </div>

                    <div class="card-footer clearfix bg-white">
                        <ul class="pagination m-0">
                            <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                                <a class="page-link "
                                   href="{{ url(null, null, [ 'page' => $page - 1]) }}">«</a>
                            </li>
                            @if($page > 1)
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ url(null, null, [ 'page' => $page - 1]) }}">{{ $page - 1 }}</a>
                                </li>
                            @endif
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ $page }}</a>
                            </li>
                            @if($page + 1 <= $total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ url(null, null, [ 'page' => $page + 1]) }}">{{ $page + 1 }}</a>
                                </li>
                            @endif

                            @if($page + 2 <= $total_page)
                                <li class="page-item">
                                    <a class="page-link"
                                       href="{{ url(null, null, [ 'page' => $page + 2 ]) }}">{{ $page + 2 }}</a>
                                </li>
                            @endif

                            <li class="page-item {{ $page >= $total_page ? 'disabled' : '' }}">
                                <a class="page-link"
                                   href="{{ url(null, null, [ 'page' => $page + 1]) }}">»</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </div>


@stop