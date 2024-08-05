<form id="modal-form" action="/api/add-coin/<?php echo e($user->id); ?>" type="POST">
    <div class="form-group">
        <label for="username">Coin Hiện Tại</label>
        <input type="number" disabled class="form-control" value="<?php echo e($user->coin); ?>">
    </div>

    <div class="form-group">
        <label for="username">Cộng Thêm</label>
        <input type="number" class="form-control" id="usercoin" name="coin">
    </div>

</form>

<script>
    $( "#modal-form" ).submit(function( event ) {
        event.preventDefault();
        $("#submit").click();
    });
</script><?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/components/form/add-coin.blade.php ENDPATH**/ ?>