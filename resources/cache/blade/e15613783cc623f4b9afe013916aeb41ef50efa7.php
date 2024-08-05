
<?php $__env->startSection('title', L::_("Add Coin")); ?>

<?php $__env->startSection('content'); ?>
<div id="main-wrapper">
    <div class="container">
        <div id="mw-2col">
            <!--Begin: main-content-->
            <div id="main-content">
                <section class="block_area ">
                    <div class="block_area-header block_area-header-tabs">
                        <div class="float-left bah-heading">
                            <h2 class="cat-heading"><?php echo e(L::_("Nạp Token")); ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="block_area-content">
                        <div class="description mb-4">
                            <p>10k VND = <?php echo e((10000 * $_ENV['tranfer_rate'])); ?> Token</p>
                            <p>- Vui lòng chọn nhà mạng và mệnh giá cần nạp.</p>
                            <p>- Sai mệnh giá bị trừ 50% giá trị thẻ</p>

                            <p>- Sau khi nạp thành công, vui lòng chờ 1-2 phút để hệ thống cập nhật số dư.</p>
                        </div>
                        <form class="preform preform pr-settings" method="post" id="napthe-form">
                            <?php
                            $networks = [
                                'VTT' => 'VIETTEL',
                                'VMS' => 'MOBIFONE',
                                'VNP' => 'VINAPHONE',
                                'VNM' => 'VIETNAMMOBILE',
                            ];

                            ?>
                            <select class="form-control" id="nha_mang" name="telco" onchange="showMenhGia(this)">
                                <?php $__currentLoopData = $price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>"><?php echo e($networks[$key] ?? $key); ?></option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <?php $__currentLoopData = $price; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <select class="form-control menh-gia mt-3" id="<?php echo e($key); ?>" style="display: none;">
                                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v['value']); ?>"><?php echo e(number_format($v['value'], 0, '.', ',')); ?> VND
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <input class="form-control mt-3" type="type" name="serial" placeholder="Serial" required>
                            <input class="form-control mt-3" type="type" name="code" placeholder="Mã thẻ" required>


                            <div class="form-group mb-0">
                                <div class="mt-3">&nbsp;</div>
                                <button class="btn btn-block btn-primary">Nạp Ngay</button>
                                <div class="loading-relative" id="import-loading" style="display:none">
                                    <div class="loading">
                                        <div class="span1"></div>
                                        <div class="span2"></div>
                                        <div class="span3"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section class="block_area ">

                    <div class="block_area-header block_area-header-tabs">
                        <div class="float-left bah-heading">
                            <h2 class="cat-heading"><?php echo e(L::_("Lịch Sử Nạp")); ?></h2>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="block_area-content">
                        <?php
                        $history = \Models\Model::getDB()->where('user_id', userget()->id)->orderBy('id',
                        'desc')->objectBuilder()->get('user_payment');
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Nhà Mạng</th>
                                    <th scope="col">Mệnh giá</th>
                                    <th scope="col">Tình trạng</th>
                                    <th scope="col">Ngày nạp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $card = json_decode($item->card_data);
                                ?>
                                <tr>
                                    <td><?php echo e($card->telco); ?></td>
                                    <td><?php echo e(number_format($card->amount, 0, '.', ',')); ?> VND</td>
                                    <td><?php echo e($item->status); ?></td>
                                    <td><?php echo e($item->payment_date); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>


                </section>
            </div>

            <!--/End: main-content-->

            <!--Begin: main-sidebar-->
            <?php echo $__env->make('themes.mangareader.components.user.main-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--/End: main-sidebar-->
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
<script type="text/javascript">
    var current = document.querySelector('#nha_mang').value;
    document.querySelector('#' + current).style.display = 'block';

    var tableMode = [...document.querySelectorAll(".table")];
    activeUiMode();

    const showMenhGia = function(vm) {
        var allMenhGia = document.getElementsByClassName('menh-gia');
        for (var i = 0; i < allMenhGia.length; i++) {
            allMenhGia[i].style.display = 'none';
        }

        var menhGia = document.getElementById(vm.value);
        menhGia.style.display = 'block';
    }

    $("#napthe-form").on("submit", function(e) {
        e.preventDefault();

        var form = $(this);
        var data = form.serializeArray();

        var amount = $("#napthe-form .menh-gia:visible").val();

        data.push({
            name: 'amount'
            , value: amount
        });


        var loading = $("#import-loading");
        loading.show();

        $.post('/user/payment/charging', data, function(res) {
            alert(res.message);
            loading.hide();
        });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/pages/payment.blade.php ENDPATH**/ ?>