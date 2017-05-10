@extends('layouts.admin')

@section('title')
Edit Attribute
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="attribute-edit">
        <h3>#{{ $attribute->id . ' ' . $attribute->name }}</h3>
        <form id="edit-attribute-form" role="form" method="POST"
              action="{{ url('/admin/attribute/update', ['specificationId' => $specificationId, 'id' => $attribute->id]) }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/specification/edit', ['specificationId' => $specificationId]) }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>Back
                    </a>
                </div>
                <button id="entity-delete" type="submit" name="submit" value="delete" formnovalidate>Delete</button>
                <button class="entity-save" type="submit" name="submit" value="save">Save</button>
            </div>
            <div class="attribute-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="attribute-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="name">Name</label></td>
                            <td><input type="text" name="name" required value="{{ $attribute->name }}"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection