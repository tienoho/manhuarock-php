<form id="modal-form" action="/api/add-group" type="POST">
    <div class="form-group">
        <label for="groupname">Tên Nhóm Dịch</label>
        <input type="text" class="form-control" id="groupname" name="name" placeholder="Tên Nhóm Dịch">
    </div>

    <div class="form-group">
        <label for="groupdescription">Mô Tả</label>
        <textarea type="text" class="form-control" id="groupdescription" name="description" rows="3"></textarea>
    </div>
</form>

<script>
    $( "#modal-form" ).submit(function( event ) {
        event.preventDefault();
        $("#submit").click();
    });
</script>

