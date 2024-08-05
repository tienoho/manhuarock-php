<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="row">
                    <div class="col-lg-3 col-6">

                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $manga->total }} </h3>
                                <div class="icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <p>Truyện Đã Upload</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ url("admin.manga-manage") }}" class="small-box-footer">Xem thêm <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $group->total ?? 0 }}</h3>

                                <p>Nhóm Đã Tham Gia</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="#" class="small-box-footer">Xem thêm <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $chapters->totalview ?? 0 }}</h3>

                                <p>Tổng Số Views</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <a href="{{ url('admin.user-manage') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $administration_conf['rate'] ?? 0 }}đ</h3>

                                <p>Rate Tháng Này</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">Xem thêm <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ (($chapters->totalearned ?? 0) - ($received ?? 0)) }}đ</h3>

                                <p>Tiền Chưa Rút</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">Rút ngay <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3>{{ $chapters->totalearned ?? 0 }}đ</h3>

                                <p>Tiền Đã Kiếm Được</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">Xem thêm <i
                                        class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>
            </div>
        </div>
    </div>
</section>