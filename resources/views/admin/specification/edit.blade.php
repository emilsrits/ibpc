@extends('layouts.master')

@section('title')
Edit Attribute Group
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="specification-edit">
            <h3>#{{ $specification->id . ' ' . $specification->name }}</h3>
            <form id="edit-specification-form" role="form" method="POST" action="{{ url('/admin/specification/update', ['id' => $specification->id]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="manage-btn-group">
                    <div class="btn-manage-back">
                        <a href="{{ url('/admin/specifications') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                    </div>
                    <button id="entity-delete" type="submit" name="submit" value="delete" formnovalidate>Delete</button>
                    <button class="entity-save" type="submit" name="submit" value="save">Save</button>
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
                                <td><input type="text" name="slug" required value="{{ $specification->slug }}"></td>
                            </tr>
                            <tr class="entity-attribute">
                                <td><label for="name">Name</label></td>
                                <td><input type="text" name="name" required value="{{ $specification->name }}"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            <div class="attribute-content-section">
                <div class="content-section-toggle">
                    <strong>Attributes<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
                </div>
                <div class="content-container">
                    <div class="manage-btn-group">
                        <div class="btn-manage-add">
                            <a href="{{ url('/admin/attribute/create', ['id' => $specification->id]) }}">Add Attribute</a>
                        </div>
                    </div>
                    <form id="attributes-form" role="form" method="POST" action="{{ url('/admin/attributes/action') }}">
                        {{ csrf_field() }}
                        <div class="attributes-action">
                            <select id="mass-action" name="mass-action">
                                <option value="0"></option>
                                <option value="1">Delete</option>
                            </select>
                            <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                        </div>
                        <table id="attributes-table">
                            <thead class="table-head">
                            <tr>
                                <th>
                                    <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                                </th>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="table-body">
                            @foreach($specification->attributes as $attribute)
                                <tr>
                                    <td>
                                        <input class="entity-select" type="checkbox" name="attributes[{{ $attribute->id }}][id]" value="{{ $attribute->id }}">
                                    </td>
                                    <td>{{ $attribute->id }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>{{ $attribute->created_at }}</td>
                                    <td>{{ $attribute->updated_at }}</td>
                                    <td>
                                        <a href="{{ url('/admin/attribute/edit', ['specificationId' => $specification->id, 'id' => $attribute->id]) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection