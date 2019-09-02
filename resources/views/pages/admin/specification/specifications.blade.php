@extends('layouts.admin')

@section('title')
Property Groups
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Property Groups</h1>

            <entity-manage
                :routes="{
                    add: '{{ url('/admin/specification/create') }}'
                }"
            >
            </entity-manage>

            <table-form
                action="{{ url('/admin/specifications') }}"
            >
                <template v-slot:select-options>
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