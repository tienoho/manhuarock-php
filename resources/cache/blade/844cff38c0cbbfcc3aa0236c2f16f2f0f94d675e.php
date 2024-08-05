<form id="modal-form" action="/api/group-edit/<?php echo e($group->id); ?>" type="POST">
    <div class="form-group">
        <label for="groupname">Tên Nhóm Dịch</label>
        <input type="text" class="form-control" id="groupname" name="name" value="<?php echo e($group->name); ?>">
    </div>

    <div class="form-group">
        <label for="groupdescription">Mô Tả</label>
        <textarea type="text" class="form-control" id="groupdescription" name="description" rows="3"><?php echo e($group->description); ?></textarea>
    </div>
</form>

<script>
    $( "#modal-form" ).submit(function( event ) {
        event.preventDefault();
        $("#submit").click();
    });
</script>

<?php /**PATH /www/wwwroot/2ten.net/resources/views/admin/components/form/group-edit.blade.php ENDPATH**/ ?>