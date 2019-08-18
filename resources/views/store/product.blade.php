@extends('layouts.master')

@section('title')
{{ $product->code }}
@endsection

@section('content')
<div class="section">
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-12-mobile is-3-tablet is-2-widescreen">
                @include('partials.store.categories')
            </div>

            <div class="column is-12-mobile is-9-tablet is-10-widescreen">
                <div id="product-view" class="columns is-multiline">
                    <div id="product-details" class="column is-12-mobile is-8-tablet">
                        <product-details
                            :product="{{ json_encode($product) }}"
                            :media="'{{ $product->image }}'"
                        >
                            <template v-slot:product-gallery>
                                @if(count($product->media) > 1)
                                    <div class="product-media-thumbs">
                                        @foreach($product->getImages(5, 1) as $image)
                                            <div class="product-media-item">
                                                <img src="{{ $image->path }}" alt="{{ $image->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </template>
                            
                            <template v-slot:product-properties>
                                <table class="product-properties">
                                    <tbody>
                                    @if($product->properties->first())
                                        @foreach($product->groupPropertiesBySpecification() as $specification => $properties)
                                            <tr class="category">
                                                <td>{{ $specification }}</td>
                                            </tr>
                                            @foreach($properties as $key => $property)
                                                <tr class="specification">
                                                    <td class="property">{{ $property['name'] }}</td>
                                                    <td class="value">{{ $property['value'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                    @if($product->description)
                                        <tr class="category">
                                            <td>Additional Information</td>
                                        </tr>
                                        <tr class="specification">
                                            <td class="property">Description</td>
                                            <td class="value">{{ $product->description }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </template>
                        </product-details>
                    </div>
                    
                    <div id="product-form" class="column is-12-mobile is-4-tablet">
                        <product-form
                            :product="{{ json_encode($product) }}"
                            :product-prices="{
                                current: '{{ money($product->price) }}',
                                old: '{{ $product->old_price ? money($product->old_price) : null }}'
                            }"
                            :route="'{{ url('/cart/add', ['id' => $product->id]) }}'"
                        >
                        </product-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection