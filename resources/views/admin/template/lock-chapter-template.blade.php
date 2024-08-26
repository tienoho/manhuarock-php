<div class="modal fade" id="ajax-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Khóa chap: {{ $chap->name }} - {{ $chapter_id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
            <form id="frmLockChapter" action="/api/lock-chapter/{{ $chapter_id }}" method="POST">
                <div class="modal-body">
                    <div class="form-group ">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="is_lock" id="lock-chapter" {{ $chap->is_lock?'checked':'' }}>
                            <label class="custom-control-label" for="lock-chapter">Khóa chap</label>
                        </div>
                    </div>
                    <div class="form-group f-price" style="display: {{ $chap->is_lock?'block':'none' }};">
                       <label>Coin:</label>
                       <input id="price" class="form-control" name="price" type="number" placeholder="Nhập số coin" value="{{ $chap->price }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Xác Nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script> 
    
    $('#frmLockChapter #lock-chapter').on('change', function() {
        if ($(this).is(':checked')) {
            $('.f-price').show();
        } else {
            $('.f-price').hide();
        }
    });
</script>
