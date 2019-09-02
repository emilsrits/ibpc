@extends('layouts.admin')

@section('title')
Create Product
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">New Product</h1>

            <form id="entity-create-form" role="form" method="POST" action="{{ url('/admin/product/create') }}" enctype="multipart/form-data">
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/catalog') }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
                        <entity-product-categories>
                            <template v-slot:select-options>
                                @foreach($categories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('category') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </template>
                        </entity-product-categories>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <label class="label is-small" for="code">Code</label>
                                    <div class="control">
                                        <input class="input" type="text" name="code" required value="{{ old('code') }}">
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small" for="title">Title</label>
                                    <div class="control">
                                        <input class="input" type="text" name="title" required value="{{ old('title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="description">Description</label>
                            <textarea class="textarea" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <label class="label is-small" for="price">Price {{ config('constants.currency') }}</label>
                                    <div class="control">
                                        <input class="input" type="text" name="price" required pattern="^[0-9]*\.[0-9]{2}|[0-9]*$" value="{{ old('price') }}">
                                    </div>
                                </div>

                                <div class="field is-narrow">
                                    <label class="label is-small" for="stock">Stock</label>
                                    <div class="control">
                                        <input class="input" type="number" min="0" max="1000" name="stock" required value="{{ old('stock') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="status">Status</label>
                            <div class="control">
                                <div class="select">
                                    <select name="status" required>
                                        <option value="0" {{ old('status') === (string)0 ? 'selected' : '' }}>Disabled</option>
                                        <option value="1" {{ old('status') === (string)1 ? 'selected' : '' }}>Enabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Media</h2>
                    </div>

                    <div class="column is-9">
                        <entity-product-media></entity-product-media>
                    </div>
                </div>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">Properties</h2>
                    </div>

                    <div class="column is-9">
                        @include('pages.admin.product._partials.specifications')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection