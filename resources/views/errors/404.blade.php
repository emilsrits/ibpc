@extends('layouts.master')

@section('title')
Page not found
@endsection

@section('styles')
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

<style>
    .title-404 {
        margin: 5% auto;
        padding: 0 10px;
        width: 100%;
        height: 350px;
        font-family: 'Lato', sans-serif;
        font-size: 50px;
        font-weight: bold;
        text-align: center;
        background: url({{ asset("/images/pepe.png") }}) no-repeat center;
        background-size: contain;
    }
</style>
@endsection

@section('content')
<div class="title-404">You sure about that?<p>404</p></div>
@endsection
