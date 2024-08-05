

<?php $__env->startSection('css_plugins'); ?>
    <link rel="stylesheet" href="/admin/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/admin/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="/admin/css/buttons.bootstrap4.min.css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Danh Sách Truyện</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin')); ?>">Admin</a></li>
                            <li class="breadcrumb-item active">Danh Sách Truyện</li>
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
                                <h3 class="card-title">Tất cả truyện</h3>

                                <div class="card-tools">
                                    <a href="<?php echo e(url('admin.manga-add')); ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Thêm
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="table"
                                                   class="table table-bordered table-hover dataTable dtr-inline"
                                                   role="grid" aria-describedby="table">
                                                <thead>
                                                <tr>
                                                    <th>Bìa</th>
                                                    <th>Tên Truyện</th>
                                                    <th>Cập Nhật</th>
                                                    <th>Chương Mới</th>
                                                    <th>T.Trạng</th>
                                                    <th>Chế Độ</th>
                                                    <th>Hành Động</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <tr>
                                                    <th>Bìa</th>
                                                    <th>Tên Truyện</th>
                                                    <th>Cập Nhật</th>
                                                    <th>Chương Mới</th>
                                                    <th>T.Trạng</th>
                                                    <th>Chế Độ</th>
                                                    <th>Hành Động</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript_plugins'); ?>
    <!-- DataTables  & Plugins -->
    <script src="/admin/js/jquery.dataTables.min.js"></script>
    <script src="/admin/js/dataTables.bootstrap4.min.js"></script>
    <script src="/admin/js/dataTables.responsive.min.js"></script>
    <script src="/admin/js/responsive.bootstrap4.min.js"></script>

    <script>




        var table = $("#table").DataTable({
            "lengthChange": true, "autoWidth": false,
            "stateSave": true,
            "pageLength": 25,
            "scrollX"   : true,
            "lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
            "processing": true,
            "serverSide": true,
            "order": [
                [ 2, "desc" ]
            ],
            "ajax": {
                "url": "<?php echo e(url('api.manga-manage')); ?>",
                "type": "POST"
            },
            "columns": [
                { "data": "cover", "width": "10%", "className": "text-center" },
                { "data": "name" , "width": "20%"},
                { "data": "last_update", "width": "14%" , "className": "text-center"},
                { "data": "chapters", "width": "13%", "className": "text-center" },
                { "data": "status", "width": "10%", "className": "text-center" },
                { "data": "hidden", "width": "10%", "className": "text-center" },
                { "data": "id", "className": "text-center action" }
            ],
            "columnDefs": [
                {
                    "targets": [0, 3, 6, 4],
                    "orderable": false
                },
                {
                    "orderable": false,
                    "render": function ( data, type, row ) {
                        return `<img style="width: 100%; height: 100px; object-fit: cover;" src="${data}"/>`;
                    },
                    "targets": 0
                },
                {
                    "render": function ( data, type, row ) {
                        return `<a href="<?php echo e(url('admin.manga-edit')); ?>/${row['id']}">${data}</a>`;
                    },
                    "targets": 1
                },
                {
                    "render": function ( data, type, row ) {
                        // data = JSON.parse(data)
                        return (data.length > 0 && data[0].name ? data[0].name : "Không có chap");
                    },
                    "targets": 3
                },
                {
                    "render": function (data, type, row) {
                        return `<a href="<?php echo e(url('admin.chapter-add')); ?>/${data}" class="btn btn-primary btn-sm">Thêm</a> <a href="<?php echo e(url('admin.manga-edit')); ?>/${data}" class="btn btn-info btn-sm">Sửa</a> <a class="btn btn-danger btn-sm delete-manga" data-id="${data}">Xoá</a>`;
                    },
                    "targets": 6
                },
                {
                    "render": function (data, type, row) {
                        return data === 0 ? 'Công khai' : 'Bản Nháp'
                    },
                    "targets": 5
                }
            ]
        })

        $(document).on('click', '.delete-manga', function (e) {
            var manga_id = $(this).data('id');

            DeleManga(manga_id);
        });

        function DeleManga(mangaids) {
            if (confirm('Xác nhận để tiếp tục hành động này!') === true) {

                $.post("/api/delete-manga", {
                    manga_ids: mangaids
                }, function (data) {
                    table.ajax.reload( null, false )
                })
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/mangarock.top/resources/views/admin/components/manga_manage/administrator.blade.php ENDPATH**/ ?>