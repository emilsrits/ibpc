@extends('layouts.admin')

@section('title')
Categories
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Category List</h1>

            <div class="entity-manage has-text-right">
                <a class="button button-action action-add" href="{{ url('/admin/category/create') }}">Add New</a>
            </div>

            <table-form
                action="{{ url('/admin/categories') }}"
            >
                <template v-slot:action-options>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                    <option value="3">Delete</option>
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($categories) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection