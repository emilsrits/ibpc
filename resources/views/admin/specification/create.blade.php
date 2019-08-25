@extends('layouts.admin')

@section('title')
Create Property Group
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">New Property Group</h1>

            <form id="entity-create-form" role="form" method="POST" action="{{ url('/admin/specification/create') }}">
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/specifications') }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field">
                            <label class="label is-small" for="slug">Slug</label>
                            <div class="control">
                                <input class="input" type="text" name="slug" required value="{{ old('slug') }}">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="name">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required value="{{ old('name') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection