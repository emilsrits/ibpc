@extends('layouts.master')

@section('title')
    Admin Panel
@endsection

@section('content')
    <div class="grid clearfix">
        <div class="grid-item lg-100 md-100 sm-100">
            <div class="manage-section manage-products">
                <h4>Products</h4>
                <a href="{{ url('/admin/products/create') }}">
                    <div class="manage-tab products-create">
                        <div class="icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
                        <div class="text">Create Products</div>
                    </div>
                </a>
                <a href="{{ url('/admin/products/edit') }}">
                    <div class="manage-tab products-edit">
                        <div class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                        <div class="text">Edit Products</div>
                    </div>
                </a>
            </div>
        </div>
    </div> <!-- grid -->
@endsection