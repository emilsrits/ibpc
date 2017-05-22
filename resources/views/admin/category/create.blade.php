@extends('layouts.admin')

@section('title')
Create Category
@endsection

@section('content')
<div class="admin-page lg-100 md-100 sm-100">
    <div class="category-create">
        <h3>New Category</h3>
        <form id="create-categories-form" role="form" method="POST" action="{{ url('/admin/category/create/save') }}">
            {{ csrf_field() }}
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin/categories') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <button class="entity-save" type="submit" name="submit">Save</button>
            </div>
            <div class="category-content-section">
                <div class="content-section-toggle">
                    <strong>General<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="category-table">
                        <tbody>
                        <tr class="entity-attribute">
                            <td><label for="title">Title</label></td>
                            <td><input type="text" name="title" required></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="parent">Parent Category</label></td>
                            <td>
                                <select id="category-parent" name="parent" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="category-parent-id" class="entity-attribute">
                            <td><label for="parent_id">Parent</label></td>
                            <td><input type="number" min="1" max="1000" name="parent_id"></td>
                        </tr>
                        <tr class="entity-attribute">
                            <td><label for="status">Status</label></td>
                            <td>
                                <select name="status" required>
                                    <option value="0">Disabled</option>
                                    <option value="1">Enabled</option>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="category-content-section">
                <div class="content-section-toggle">
                    <strong>Attribute groups<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <table class="category-table">
                        <tbody>
                        @foreach($specifications->chunk(3) as $chunk)
                            <tr class="entity-attribute">
                                @foreach($chunk as $specification)
                                    <td class="category-attribute-group">
                                        <input type="checkbox" name="{{ 'spec[' . $specification->id . '][id]' }}" value="{{ $specification->id }}">
                                        <label for="{{ 'spec[' . $specification->id . '][id]' }}">{{ $specification->slug }}</label>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection