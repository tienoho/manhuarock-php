

<?php $__env->startSection('css_plugins'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>

    <style>
        tr, .cursor-pointer {
            cursor: pointer;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="content-header"><div class="container-fluid"></div></div>
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
                                <form class="mb-2" type="POST" action="<?php echo e(url(null, ['page' => 1])); ?>">
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
                                               value="<?php echo e(input()->value('seach')); ?>">

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
                                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="group-item" data-id="<?php echo e($group->id); ?>"
                                                        data-name="<?php echo e($group->name); ?>">
                                                        <td width="30px" class="text-center align-middle">
                                                            <input
                                                                    type="checkbox"
                                                                    class="choose_box">
                                                        </td>
                                                        <td class="group-edit">
                                                            <div class="w-100"><strong><span
                                                                            class="text-info"><?php echo e($group->name); ?></span></strong>
                                                            </div>
                                                            <div class="w-100"><strong>Thành
                                                                    Viên:</strong> <?php echo e($group->total_member); ?></div>
                                                        </td>
                                                        <td class="text-center" width="180px">
                                                            <button type="button"
                                                                    class="btn btn-warning btn-sm add-member">
                                                                Thêm
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-info btn-sm group-edit">
                                                                Sửa
                                                            </button>

                                                            <button type="button"
                                                                    class="btn btn-danger btn-sm group-remove">
                                                                Xoá
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination m-0 float-right">
                                    <li class="page-item <?php echo e($page <= 1 ? 'disabled' : ''); ?>">
                                        <a class="page-link " href="<?php echo e(url(null, ['page' => $page - 1])); ?>">«</a>
                                    </li>
                                    <?php if($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page - 1])); ?>"><?php echo e($page - 1); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="#"><?php echo e($page); ?></a>
                                    </li>
                                    <?php if($page + 1 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 1])); ?>"><?php echo e($page + 1); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($page + 2 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 2])); ?>"><?php echo e($page + 2); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <li class="page-item <?php echo e($page >= $total_page ? 'disabled' : ''); ?>">
                                        <a class="page-link" href="<?php echo e(url(null, ['page' => $page + 1])); ?>">»</a>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript_plugins'); ?>
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

        function addGroup(){
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
                $.post("/api/delete-taxonomy", {
                    taxonomy: taxonomy
                }, function (data) {
                    location.reload();
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

        CreateAjax(".group-edit", "/api/group-edit/", "Sửa Thông Tin ");
        CreateAjax(".add-member", "/api/add-member/", "Thêm Thành Viên Vào ");
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
            integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/v2.manhuarockz.com/resources/views/admin/pages/group_manage.blade.php ENDPATH**/ ?>