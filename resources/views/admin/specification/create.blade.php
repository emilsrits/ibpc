@extends('layouts.admin')

@section('title')
Create Attribute Group
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="specification-create">
        <h3>New Attribute Group</h3>
        <form id="create-specifications-form" role="form" method="POST" action="{{ url('/admin/specification/create/save') }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/specifications') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save" type="submit" name="submit">Save</button>
            </div>
            <div class="specification-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="specification-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="slug">Slug</label></td>
                            <td><input type="text" name="slug" required value="{{ old('slug') }}"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="name">Name</label></td>
                            <td><input type="text" name="name" required value="{{ old('name') }}"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection