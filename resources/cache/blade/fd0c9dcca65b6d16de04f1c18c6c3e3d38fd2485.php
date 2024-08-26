<?php $__env->startSection('css_plugins'); ?>
    <style>
        tr {
            cursor: pointer;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Quản lý phiếu nạp</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin')); ?>">Admin</a></li>
                            <li class="breadcrumb-item active">Quản lý phiếu nạp</li>
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
                                <h3 class="card-title mt-1"><i class="fas fa-list"></i> Quản lý phiếu nạp</h3>
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
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Điền mã giao dịch hoặc ID tài khoản để tìm kiếm"  value="<?php echo e(input()->value('search')); ?>">

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
                                                    <th width="50px" class="text-center align-middle"><input type="checkbox" id="choose_all"></th>
                                                    <th>Mã giao dịch</th>
                                                    <th class="text-center">Tên</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Phương thức</th>
                                                    <th class="text-center">Số tiền</th>
                                                    <th class="text-center">Trạng thái</th>
                                                    <th width="180px" class="text-center">Action</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <input hidden name="deposit_id" id="deposit_id" value="<?php echo e($deposit->deposit_id); ?>">
                                                    <tr class="user-item" data-depositid="<?php echo e($deposit-> deposit_id); ?>" data-id="<?php echo e($deposit-> user_id); ?>" data-amount="<?php echo e(number_format($deposit->amount, 0, '', '')); ?>">
                                                        <td width="30px" class="text-center align-middle"><input
                                                                    type="checkbox"
                                                                    class="choose_box">
                                                        </td>
                                                        <td><span class="text-info">#<?php echo e($deposit->code); ?></span></td>
                                                        <td class="text-center"><span><?php echo e($deposit->name); ?></span></td>
                                                        <td class="text-center"><span><?php echo e($deposit->email); ?></span></td>
                                                        <td class="text-center"><span><?php echo e($deposit->type); ?></span></td>
                                                        <td class="text-center" ><span><?php echo e(number_format($deposit->amount, 0, '', '.')); ?></span></td>
                                                        <td class="text-center">
                                                            <?php if($deposit->status == 'success'): ?>
                                                                <span class="text-success">Đã duyệt</span>
                                                            <?php elseif($deposit->status == 'pending'): ?>
                                                                <span class="text-warning">Chờ duyệt</span>
                                                            <?php elseif($deposit->status == 'reject'): ?>
                                                                <span class="text-danger">Từ chối</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center" width="200px">
                                                            <?php if($deposit->status == 'pending'): ?>
                                                              <button type="button" class="btn btn-info btn-sm add-coin">
                                                                    Duyệt
                                                                </button>
                                                
                                                                <button type="button" class="btn btn-danger btn-sm reject" onclick="Reject(<?php echo e($deposit->id); ?>)">
                                                                    Từ chối
                                                                </button>
                                                            <?php else: ?>
                                                                <button type="button" class="btn btn-info btn-sm" disabled>
                                                                   Hoàn thành
                                                                </button>
                                                            <?php endif; ?>
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
                                        <a class="page-link " href="<?php echo e(url(null, ['page' => $page - 1], ['search' => input()->value('search')])); ?>">«</a>
                                    </li>
                                    <?php if($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page - 1], ['search' => input()->value('search')])); ?>"><?php echo e($page - 1); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="#"><?php echo e($page); ?></a>
                                    </li>
                                    <?php if($page + 1 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 1], ['search' => input()->value('search')])); ?>"><?php echo e($page + 1); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if($page + 2 <= $total_page): ?>
                                        <li class="page-item">
                                            <a class="page-link"
                                               href="<?php echo e(url(null, ['page' => $page + 2, ], ['search' => input()->value('search')])); ?>"><?php echo e($page + 2); ?></a>
                                        </li>
                                    <?php endif; ?>

                                    <li class="page-item <?php echo e($page >= $total_page ? 'disabled' : ''); ?>">
                                        <a class="page-link" href="<?php echo e(url(null, ['page' => $page + 1], ['search' => input()->value('search')])); ?>">»</a>
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
                    <button id="submit" type="button" class="btn btn-primary submitForm">Lưu thay đổi</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript_plugins'); ?>
    <script>
        function Reject(){
            if(confirm('Xác nhận từ chối yêu cầu!') === true){
                var depositId = $('#depositId').val();
                $.ajax({
                    url: '/ajax/depositReject',
                    type: 'POST',
                    data: { id: depositId },
                    success: function(response) {
                        if (response.status) {
                            alert('Deposit status updated successfully.');
                        } else {
                            alert('Failed to update deposit status: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
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
            var depositId = $('#depositId').val();
        $.ajax({
            type: "POST",
            url: '/ajax/depositApprove/',
            data: { id: depositId },
        })
        
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
        
   function CreateAjax(className, URL, title) {
        $(document).on('click', className, function () {
            var parents = $(this).parents(".user-item");
            var user_id = $(parents).data("id");
            var amount = $(parents).data("amount");
            var depositId = $(parents).data("depositid");
            
            $.get(URL + user_id, { amount: amount }, function (data) {
                $('#modal-user').modal('show');
                $('.modal-title').text(title + user_id);
    
                $('.modal-body').html(data);
    
                $('#usercoin').val(amount);
                
                $('#depositId').val(depositId)
            });
          
        });
    }
        
        CreateAjax(".add-coin", "/api/add-coin/", "Thêm Coin Cho Tài Khoản: ");
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/manhuarockz.com/resources/views/admin/pages/deposit.blade.php ENDPATH**/ ?>