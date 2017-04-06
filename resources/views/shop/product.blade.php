@extends('layouts.master')

@section('title')
    {{ $product->code }}
@endsection

@section('content')
    <div class="grid clearfix">
        @include('partials.sidebar')
        <div class="grid-item lg-85">

        </div>
    </div>
@endsection