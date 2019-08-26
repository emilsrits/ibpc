@extends('layouts.admin')

@section('title')
Edit Property Group
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $specification->id . ' ' . $specification->name }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/specification/update', ['id' => $specification->id]) }}">
                @method('PATCH')
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/specifications') }}',
                        delete: '{{ route('specification.delete', ['id' => $specification->id], false) }}'
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
                                <input class="input" type="text" name="slug" required value="{{ old('slug', $specification->slug) }}">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="name">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" required value="{{ old('name', $specification->name) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="box">
            <h1 class="is-size-5">Properties</h1>

            <entity-manage
                :routes="{
                    add: '{{ url('/admin/property/create', ['id' => $specification->id]) }}'
                }"
            >
            </entity-manage>

            <table-form
                action="{{ url('/admin/properties') }}"
            >
                <template v-slot:select-options>
                    <option value="1">Delete</option>
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($specification->properties) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection