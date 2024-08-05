@extends('admin.layout')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid"></div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">

                    @if(!$type)
                        <div class="card-header">
                            <h2 class="card-title">Quản lí Taxonomy</h2>
                        </div>

                        <div class="card-body">
                            @include('admin.components.taxonomy.all')
                        </div>
                    @else
                        <div class="card-header">
                            <h3 class="card-title">Quản lí Taxonomy: {{ $type }}</h3>
                            <div class="card-tools">
                                <a id="add-taxonomy" data-taxonomy="{{ $type }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus"></i> Thêm</a>
                            </div>
                        </div>

                        <div class="card-body">
                            @include('admin.components.taxonomy.detail-list')
                        </div>
                        <div class="card-footer clearfix bg-white">
                            <ul class="pagination m-0">
                                <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                                    <a class="page-link " href="{{ url(null, null, ['s' => $search, 'page' => $page - 1]) }}">«</a>
                                </li>
                                @if($page > 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ url(null, null, ['s' => $search, 'page' => $page - 1]) }}">{{ $page - 1 }}</a>
                                    </li>
                                @endif
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ $page }}</a>
                                </li>
                                @if($page + 1 <= $total_page)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ url(null, null, ['s' => $search, 'page' => $page + 1]) }}">{{ $page + 1 }}</a>
                                    </li>
                                @endif

                                @if($page + 2 <= $total_page)
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ url(null, null, ['s' => $search, 'page' => $page + 2 ]) }}">{{ $page + 2 }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $page >= $total_page ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url(null, null, ['s' => $search, 'page' => $page + 1]) }}">»</a>
                                </li>

                            </ul>
                        </div>
                    @endif
                </div>
            </div>

        </section>

    </div>


@stop