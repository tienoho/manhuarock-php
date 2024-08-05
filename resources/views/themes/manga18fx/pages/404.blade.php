@extends('themes.manga18fx.layouts.full')

@section('title', "Nội Dung Này Không Còn Tồn Tại!")

@section('content')
    <?php response()->httpCode(301)->redirect('/'); ?>
@stop