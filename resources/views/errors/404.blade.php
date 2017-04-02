@extends('layouts.master')

@section('title')
    Page not found
@endsection

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        .title-404 {
            margin: 20% auto;
            width: 100%;
            height: 350px;
            font-family: 'Lato', sans-serif;
            font-size: 72px;
            font-weight: bold;
            text-align: center;
            background: url({{ asset("/images/pepe.png") }}) no-repeat center;
        }
    </style>
@endsection

@section('content')
    <div class="title-404">You sure about that?<p>404</p></div>
@endsection
