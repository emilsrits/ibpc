@extends('layouts.admin')

@section('title')
Catalog
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Product List</h1>

            <entity-manage
                :routes="{
                    add: '{{ url('/admin/product/create') }}'
                }"
            >
            </entity-manage>

            <table-form
                action="{{ url('/admin/catalog') }}"
            >
                <template v-slot:select-options>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                    <option value="3">Delete</option>
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($products) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection