@extends('layouts.master')

@section('title')
    {{ $product->code }}
@endsection

@section('content')
    <div class="grid clearfix">
        @include('partials.sidebar')
        <div class="grid-item large-85">

        </div>
    </div>
@endsection