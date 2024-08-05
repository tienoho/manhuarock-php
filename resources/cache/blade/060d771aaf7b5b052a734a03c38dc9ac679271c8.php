

<?php $__env->startSection('content'); ?>
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
                            <div class="card-header">
                                Tìm truyện cần ghim:
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input id="search-pin" type="search" class="form-control form-control-lg" placeholder="Nhập tên truyện ở đây" value="">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" id="searching">
                                    <div class="mt-3 d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>

                                <div id="search-result" class="mt-3">

                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                Truyện đã ghim
                            </div>
                            <div id="pinlist" class="card-body">
                                <div id="pinloading">
                                    <div class="mt-3 d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>

    <style>
        .pin-item {
            margin: 15px 5px;
            cursor: pointer;
        }

        .pin-title {
            font-weight: 600;
        }

        .pin-title:hover {
            color: #ff0c0c;
        }
    </style>
    <script>
        var page = <?php echo e($page); ?>;
        getPin();

        $("input#search-pin").on('keyup', function (e) {
            var search_val = ($(this).val())

            $("#searching").show();

            $.post("/api/search-pin", {search: search_val}, function(result){

                $("#searching").hide();

                $("#search-result").html(result)
            });
        });
        $(document).on('click', '.pin-item', function () {
            var id = $(this).data('id')

            $.post("/api/remove-pin", {manga_id: id}, function(result){
                $(document).Toasts('create', {
                    class: 'bg-danger m-1',
                    title: 'Thông báo',
                    body: 'Đã xoá truyện khỏi danh sách ghim'
                });

                $("#pinlist").empty();
                page = 1;
                getPin();
            });
        });

        $(document).on('click', '.search-item', function () {
            var id = $(this).data('id')

            $.post("/api/set-pin", {manga_id: id}, function(result){
                $(document).Toasts('create', {
                    class: 'bg-success m-1',
                    title: 'Thông báo',
                    body: 'Đã thêm truyện vào danh sách ghim'
                });

                $("#pinlist").empty();
                page = 1;
                getPin();
            });


        });

        function getPin(){
            $("#pinloading").show();

            $.post("/api/get-pin", { page: page }, function(result){
                $("#pinloading").hide()
                $("#pinlist").append(result)
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/pages/pin_manga.blade.php ENDPATH**/ ?>