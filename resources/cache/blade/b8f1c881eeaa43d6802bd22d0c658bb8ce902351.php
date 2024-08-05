

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
                                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    $item->metadata = json_decode($item->metadata);
                                                    ?>
                                                    <tr class="group-item" data-id="<?php echo e($item->id); ?>" data-user-id="<?php echo e($item->user_id); ?>"
                                                        data-name="<?php echo e($item->name); ?>" data-type="<?php echo e($item->type); ?>">
                                                        <td width="30px" class="text-center align-middle">
                                                            <input
                                                                    type="checkbox"
                                                                    class="choose_box">
                                                        </td>
                                                        <td>
                                                            <div class="w-100"><strong><span
                                                                            class="text-info"><?php echo e($item->name); ?></span></strong>
                                                                <?php if($item->metadata->name_group): ?>
                                                                    <span class="ml-2 mb-1 badge badge-info"><?php echo e($item->metadata->name_group); ?></span>
                                                                <?php endif; ?>                                                            </div>

                                                            <i class="w-100">
                                                                <a style="font-size: 14px" class="link-highlight " href="<?php echo e($item->metadata->url_produce); ?>"> <?php echo e($item->metadata->url_produce); ?> </a>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript_plugins'); ?>
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


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/admin/pages/user_request.blade.php ENDPATH**/ ?>