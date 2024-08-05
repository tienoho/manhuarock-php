<form id="modal-form" action="/api/user-edit/{{ $user->id }}" type="POST">
    <div class="form-group">
        <label for="username">Họ & Tên</label>
        <input type="text" class="form-control" id="username" name="name" value="{{ $user->name }}">
    </div>

    <div class="form-group">
        <label for="username">Email đăng nhập</label>
        <input type="email" class="form-control" id="useremail" name="email" value="{{ $user->email }}">
    </div>

    <div class="form-group">
        <label>Vai Trò</label>
        <select name="role" class="form-control">
            @foreach((new \Models\User())->user_roles as $key => $value)
                <option {{ $user->role === $key ? 'selected' : '' }} value="{{ $key }}"> {{ $value }} </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="username">Coin</label>
        <input type="number" class="form-control" id="usercoin" name="coin" value="{{ $user->coin }}">
    </div>
</form>

<script>
    $( "#modal-form" ).submit(function( event ) {
        event.preventDefault();
        $("#submit").click();
    });
</script>