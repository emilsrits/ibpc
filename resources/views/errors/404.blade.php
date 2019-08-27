@extends('layouts.store')

@section('title')
Page not found
@endsection

@section('styles')
<style>
    .title {
        margin: 40px auto;
        padding: 0 10px;
        width: 100%;
        height: 350px;
        color: #bebebe;
        font-weight: bold;
        text-align: center;
    }

    .title h1 {
        font-size: 45px;
    }

    .title p {
        padding: 20px;
        font-size: 15px;
    }
</style>
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div class="title has-text-centered">
            <h1>Page not found</h1>
            <p>We're sorry, we couldn't find the page you requested.</p>
        </div>
    </div>
</div>
@endsection
