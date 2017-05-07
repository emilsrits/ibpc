@extends('layouts.master')

@section('title')
Attribute Groups
@endsection

@section('content')
    <div class="admin-page lg-100 md-100 sm-100">
        <div class="product-attribute-groups">
            <h3>Attribute Groups</h3>
            <div class="manage-btn-group">
                <div class="btn-manage-back">
                    <a href="{{ url('/admin') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a>
                </div>
                <div class="btn-manage-add">
                    <a href="{{ url('/admin/specification/create') }}">Add Attribute Group</a>
                </div>
            </div>
            <form id="specifications-form" role="form" method="POST" action="{{ url('/admin/specifications/action') }}">
                {{ csrf_field() }}
                <div class="specifications-action">
                    <select id="mass-action" name="mass-action">
                        <option value="0"></option>
                        <option value="1">Delete</option>
                    </select>
                    <button id="mass-action-run" type="submit" name="submit"><i class="fa fa-play" aria-hidden="true"></i></button>
                </div>
                {{ $specifications->appends(Request::except('page'))->links() }}
                <table id="specifications-table">
                    <thead class="table-head">
                    <tr>
                        <th>
                            <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                        </th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Attributes</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="table-body">
                    @foreach($specifications as $specification)
                        <tr>
                            <td>
                                <input class="entity-select" type="checkbox" name="specifications[{{ $specification->id }}][id]" value="{{ $specification->id }}">
                            </td>
                            <td>{{ $specification->id }}</td>
                            <td>{{ $specification->name }}</td>
                            <td>{{ $specification->attributes->count() }}</td>
                            <td>{{ $specification->created_at }}</td>
                            <td>{{ $specification->updated_at }}</td>
                            <td>
                                <a href="{{ url('/admin/specification/edit', ['id' => $specification->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($specifications->count() > 20)
                    {{ $specifications->appends(Request::except('page'))->links() }}
                @endif
            </form>
        </div>
    </div>
@endsection