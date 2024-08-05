<form id="modal-form" action="/api/user-edit/<?php echo e($user->id); ?>" type="POST">
    <div class="form-group">
        <label for="username">Họ & Tên</label>
        <input type="text" class="form-control" id="username" name="name" value="<?php echo e($user->name); ?>">
    </div>

    <div class="form-group">
        <label for="username">Email đăng nhập</label>
        <input type="email" class="form-control" id="useremail" name="email" value="<?php echo e($user->email); ?>">
    </div>

    <div class="form-group">
        <label>Vai Trò</label>
        <select name="role" class="form-control">
            <?php $__currentLoopData = (new \Models\User())->user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option <?php echo e($user->role === $key ? 'selected' : ''); ?> value="<?php echo e($key); ?>"> <?php echo e($value); ?> </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Coin</label>
        <input type="number" class="form-control" id="usercoin" name="coin" value="<?php echo e($user->coin); ?>">
    </div>
</form>

<script>
    $( "#modal-form" ).submit(function( event ) {
        event.preventDefault();
        $("#submit").click();
    });
</script><?php /**PATH F:\PHP\HMT\resources\views/admin/components/form/user-edit.blade.php ENDPATH**/ ?>