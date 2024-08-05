<?php $code = ""; ?> @if(!empty($code))
@section('body')
{!!base64_decode($code)!!}
@stop
@endif