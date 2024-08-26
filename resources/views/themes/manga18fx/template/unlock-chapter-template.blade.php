<div class="modal fade" id="ajax-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mở khóa chap: <b>{{ $chap->name }}</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>            
            <form id="frmUnlockChapter" action="/api/unlock-chapter/" method="POST">
                <input type="hidden" name="reading_id" value="{{$chap->id}}"></input>
                <div class="modal-body">
                    <div class="form-group">
                    <span class="badge badge-pill badge-dark">Số Coin:</span>
                    <span class="badge badge-pill badge-success">{{ $chap->price }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Mở khóa</button>
                </div>
            </form>
        </div>
    </div>
</div>
