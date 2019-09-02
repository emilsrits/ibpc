@extends('layouts.admin')

@section('title')
Edit Product
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">#{{ $product->id . ' ' . $product->title }}</h1>

            <form id="entity-edit-form" role="form" method="POST" action="{{ url('/admin/product/update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <entity-manage
                    :routes="{
                        back: '{{ url('/admin/catalog') }}',
                        delete: '{{ route('product.delete', ['id' => $product->id], false) }}'
                    }"
                >
                </entity-manage>

                <div class="columns">
                    <div class="column is-3">
                        <h2 class="is-size-5">General</h2>
                    </div>

                    <div class="column is-9">
                        <div class="field">
                            <label class="label is-small">Category</label>
                            <div class="control">
                                <span>{{ $product->category_title }}</span>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <label class="label is-small" for="code">Code</label>
                                    <div class="control">
                                        <input class="input" type="text" name="code" required value="{{ old('code') ?? $product->code }}">
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label is-small" for="title">Title</label>
                                    <div class="control">
                                        <input class="input" type="text" name="title" required value="{{ old('title') ?? $product->title }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="description">Description</label>
                            <textarea class="textarea" name="description" rows="3">{{ old('description') ?? $product->description }}</textarea>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <label class="label is-small" for="price">Price {{ config('constants.currency') }}</label>
                                    <div class="control">
                                        <input class="input" type="text" name="price" required pattern="^[0-9]*\.[0-9]{2}|[0-9]*$" 
                                            value="{{ old('price') ?? formatMoneyByDecimal($product->price) }}">
                                    </div>
                                </div>

                                <div class="field is-narrow">
                                    <label class="label is-small" for="stock">Stock</label>
                                    <div class="control">
                                        <input class="input" type="number" min="0" max="1000" name="stock" required value="{{ old('stock') ?? $product->stock }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label is-small" for="status">Status</label>
                            <div class="control">
                                <div class="select">
                                    <select name="status" required>
                                        <option value="0" {{ old('status') === (string)0 || $product->status == 0 ? 'selected' : '' }}>Disabled</option>
                                        <option value="1" {{ old('status') === (string)1 || $product->status == 1 ? 'selected' : '' }}>Enabled</option>
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
                        <entity-product-media>
                            <template v-slot:media-preview="{deleteMedia}">
                                @if($product->media->first())
                                    @foreach($product->media as $media)
                                        <div class="media-item">
                                            <img class="image" src="{{ $media->path }}" alt="{{ $product->code }}">
                                            <button class="media-remove button button-label" data-id="{{ $media->id }}" data-product_id="{{ $product->id }}"
                                                @click="deleteMedia">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </template>
                        </entity-product-media>
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