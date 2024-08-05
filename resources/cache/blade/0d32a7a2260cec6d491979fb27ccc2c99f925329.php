
<?php $__env->startSection('title', L::_("Profile Manager")); ?>

<?php $__env->startSection('content'); ?>
    <div id="main-wrapper">
        <div class="container">
            <div id="mw-2col">
                <!--Begin: main-content-->
            <?php echo $__env->make('themes.mangareader.components.user.profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    <?php echo $__env->make('themes.mangareader.components.user.avatar-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js-body'); ?>
    <script>
        $('#profile-form').submit(function (e) {
            e.preventDefault();

            $('#profile-loading').show();

            var formData = $(this).serialize();

            $.post('/ajax/user/profile', formData, function (res) {
                $('#profile-loading').hide();
                if (res.status) {
                    $('#pro5-currentpass').val('');
                    $('#pro5-pass').val('');
                    $('#pro5-confirm').val('');
                    $('#show-changepass').collapse('hide');
                    toastr.success(res.msg, '', {timeout: 5000});
                    if ($('#note-change-email').length > 0) {
                        window.location.reload();
                    }
                } else {
                    toastr.error(res.msg, '', {timeout: 5000});
                }
            });
        });

        $('.item-avatar').click(function () {
            $('.item-avatar').removeClass('active');
            $(this).addClass('active');
            $('#preview-avatar').attr('src', $(this).find('img').attr('src'));
            $.post('/ajax/user/profile', {avatar_id: $(this).data('id')}, function (res) {
                if (res) {
                    toastr.success(res.msg, '', {timeout: 5000});
                } else {
                    toastr.error(res.msg, '', {timeout: 5000});
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.mangareader.layouts.full', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/pages/profile.blade.php ENDPATH**/ ?>