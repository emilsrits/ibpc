@extends('layouts.admin')

@section('title')
Edit Property
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $property->id . ' ' . $property->name }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/property/update', ['id' => $property->id]) }}">
                @method('PATCH')
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/specification/edit', ['specification' => $property->specification->id]) }}',
                        delete: '{{ route('property.delete', ['id' => $property->id], false) }}'
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
                                <input class="input" type="text" name="name" required value="{{ old('name', $property->name) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection