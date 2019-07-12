@extends('layouts.admin')

@section('title')
Create Property
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="property-create">
        <h3>New Property</h3>
        <form id="create-properties-form" role="form" method="POST" action="{{ url('/admin/property/create/save', ['id' => $specification->id]) }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/specification/edit', ['id' => $specification->id]) }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save" type="submit" name="submit">Save</button>
            </div>
            <div class="property-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="property-table">
                        <tbody>
                        <input type="hidden" value="{{ $specification->id }}">
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