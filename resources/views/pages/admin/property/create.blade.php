@extends('layouts.admin')

@section('title')
Create Property
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">New Property</h1>

            <form id="entity-create-form" role="form" method="POST" action="{{ url('/admin/property/create', ['id' => $specification->id]) }}">
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/specification/edit', ['id' => $specification->id]) }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
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