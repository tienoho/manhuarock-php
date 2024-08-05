<?php $code = ""; ?> @if(!empty($code))
@section('head')
{!!base64_decode($code)!!}
@stop
@endif