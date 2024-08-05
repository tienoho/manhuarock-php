<form id="modal-form" action="/api/add-member/{{ $group->id }}" type="POST">

    <div class="form-group">

        <div class="form-group">
            <label>Thêm Thành Viên</label>
            <div class="select2-purple">
                <select name="ids[]" class="select2" multiple="multiple" data-placeholder="Nhập ID, Email để tìm"
                        data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
            </div>
        </div>
    </div>
</form>

<div class="container col-12 mt-3">
    @foreach($members as $member)
        <div class="row mb-3 cursor-pointer">
            <div class="col-2 text-center">
                <img src="{{ $member->avatar_url }}" alt="user-avatar" class="img-circle img-fluid">
            </div>

            <div class="col-8">
                <p class="text-bold text-info mb-0">{{ $member->name }} <small class="badge badge-success">{{ $group->created_by == $member->id ? 'Chủ Nhóm' : 'Thành viên' }}</small></p>
                <p class="text-muted text-sm">{{ $member->email }}</p>
            </div>

            <div class="col-2 align-self-center" style="text-align-last: end">
                <button type="button" class="btn btn-danger btn-sm group-remove">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>


    @endforeach

</div>

<script>
    $("#modal-form").submit(function (event) {
        event.preventDefault();
        $("#submit").click();
    });

    $('.select2').select2({
        ajax: {
            url: '/api/search-user',
            data: function (params) {
                // Query parameters will be ?search=[term]&type=public
                return {
                    search: params.term,
                };
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.email,
                            id: item.id,
                        }
                    })
                }
            }
        },
        tags: true,
        tokenSeparators: [','],
    });

</script>

