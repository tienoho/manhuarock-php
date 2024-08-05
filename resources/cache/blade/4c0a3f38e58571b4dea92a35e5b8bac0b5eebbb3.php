<?php
use Models\User;
$avatars = User::avatarList();
$tags = array_keys($avatars);
?>
<div class="modal fade premodal premodal-avatars" id="modalavatars" tabindex="-1" role="dialog"
     aria-labelledby="modalcharacterstitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Avatar</h5>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs pre-tabs pre-tabs-min pre-tabs-hashtag" style="margin-top: -5px">
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a data-toggle="tab" href="#hashtag-<?php echo e($key); ?>" class="nav-link <?php echo e($key === 0 ? 'active' : ''); ?>">#<?php echo e($tag); ?></a>
                    </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="tab-content">
                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="hashtag-<?php echo e($key); ?>" class="tab-pane fade <?php echo e($key === 0 ? 'active show' : ''); ?>">
                        <div class="avatar-list">
                            <?php $__currentLoopData = $avatars[$tag]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $avatar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item item-avatar <?php echo e($avatar->id === userget()->avatar_id ? 'active' : ''); ?>"
                                 data-id="<?php echo e($avatar->id); ?>">
                                <div class="profile-avatar">
                                    <img src="<?php echo e($avatar->url); ?>" alt="Avatar <?php echo e($avatar->id); ?>">
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="clearfix"></div>
                <a data-dismiss="modal" aria-label="Close" class="btn btn-block btn-secondary mt-4">Close</a>
            </div>
        </div>
    </div>
</div><?php /**PATH F:\PHP\HMT\resources\views/themes/mangareader/components/user/avatar-modal.blade.php ENDPATH**/ ?>