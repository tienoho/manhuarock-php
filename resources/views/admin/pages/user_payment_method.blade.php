@extends('admin.layout')

@section('css_plugins')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@stop

@section('javascript_plugins')
    <script>

    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <form method="POST" action="{{ url('admin.payment-method') }}">
            <input aria-label name="info-payment">

            <input type="submit" value="Xác Nhận">
        </form>
    </div>
@stop