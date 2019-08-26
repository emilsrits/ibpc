@extends('layouts.store')

@section('title')
Page not found
@endsection

@section('styles')
<style>
    .title-404 {
        margin: 5% auto;
        padding: 0 10px;
        width: 100%;
        height: 350px;
        font-size: 50px;
        font-weight: bold;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="title-404">You sure about that?<p>404</p></div>
@endsection
