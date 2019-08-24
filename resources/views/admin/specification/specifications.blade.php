@extends('layouts.admin')

@section('title')
Property Groups
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Property Groups</h1>

            <div class="entity-manage has-text-right">
                <a class="button button-action action-add" href="{{ url('/admin/specification/create') }}">Add New</a>
            </div>

            <table-form
                action="{{ url('/admin/specifications') }}"
            >
                <template v-slot:action-options>
                    <option value="1">Delete</option>
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($specifications) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection