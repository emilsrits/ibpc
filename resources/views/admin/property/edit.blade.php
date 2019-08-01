@extends('layouts.admin')

@section('title')
Edit Property
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="property-edit">
        <h3>#{{ $property->id . ' ' . $property->name }}</h3>
        <form id="edit-property-form" role="form" method="POST" action="{{ url('/admin/property/update', ['id' => $property->id]) }}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/specification/edit', ['specification' => $property->specification->id]) }}">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>Back
                    </a>
                </div>
                <button id="entity-delete" data-url="{{ route('property.delete', ['id' => $property->id], false) }}" type="button">Delete</button>
                <button class="entity-save" type="submit" name="submit" value="save">Save</button>
            </div>
            <div class="property-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="property-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="name">Name</label></td>
                            <td><input type="text" name="name" required value="{{ $property->name }}"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection