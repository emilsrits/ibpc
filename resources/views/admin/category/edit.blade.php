@extends('layouts.admin')

@section('title')
Edit Category
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $category->id . ' ' . $category->title }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/category/update', ['id' => $category->id]) }}">
                @method('PATCH')
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/categories') }}',
                        delete: '{{ route('category.delete', ['id' => $category->id], false) }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field">
                            <label class="label is-small" for="title">Title</label>
                            <div class="control">
                                <input class="input" type="text" name="title" required value="{{ old('title', $category->title) }}">
                            </div>
                        </div>

                        <entity-category-parent
                            :top-level="{{ json_encode(old('top_level', $category->top_level) == 1 ? true : false) }}"
                        >
                            <template v-slot:top-level="{topCategoryChange}">
                                <div class="field is-narrow">
                                    <label class="label is-small" for="top_level">Top Category</label>
                                    <div class="control">
                                        <div class="select">
                                            <select class="input" name="top_level" required @change="topCategoryChange">
                                                <option value="0">No</option>
                                                <option value="1" {{ old('top_level', $category->top_level) == 1 ? 'selected' : '' }}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template v-slot:parent-id>
                                <div class="field is-narrow">
                                    <label class="label is-small" for="parent_id">Parent #ID</label>
                                    <div class="control">
                                        <input class="input" type="number" min="1" max="1000" name="parent_id" value="{{ old('parent_id', $category->parent_id) }}">
                                    </div>
                                </div>
                            </template>
                        </entity-category-parent>

                        <div class="field is-narrow">
                            <label class="label is-small" for="status">Status</label>
                            <div class="control">
                                <div class="select">
                                    <select class="input" name="status" required>
                                        <option value="0">Disabled</option>
                                        <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Enabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Property Groups</h2>
                    </div>

                    <div class="column is-9 scrollable-x">
                        @include('admin.category._partials.property_groups')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection