<div class="modal fade" id="ajax-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa taxonomy: {{ $taxonomy->taxonomy }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="AjaxSubmit" action="/api/edit-taxonomy/{{ $type }}" method="POST">

                <div class="modal-body">

                    <div class="form-group ">
                        <label>Tên:</label>
                        <input class="form-control" name="name" placeholder="Nhập tên" value="{{ $taxonomy->name }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả</label>

                        <textarea name="description" class="form-control" style="min-height: 100px"
                                  placeholder="Nhập mô tả...">{{ $taxonomy->description }}</textarea>
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

