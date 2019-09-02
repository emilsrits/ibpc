@extends('layouts.admin')

@section('title')
Users
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Users List</h1>

            <table-form
                action="{{ url('/admin/users') }}"
            >
                <template v-slot:select-options>
                    <option value="1">Enable</option>
                    <option value="2">Disable</option>
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($users) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection