<div id="specifications">
    @if(isset($category) && $category->specifications->first())
    @foreach($category->specifications as $key => $specification)
        <div class="specification-group">
            <h3 class="is-size-5">{{ $specification->name }}</h3>

            @foreach($specification->properties as $property)
                <div class="field">
                    <label class="label is-small" for="{{ "properties[{$specification->id}][{$property->id}]" }}">
                        {{ $property->name }}
                    </label>
                    <div class="control">
                        <input 
                            class="input is-small"
                            type="text" 
                            name="{{ "properties[{$specification->id}][{$property->id}]" }}" 
                            value="{{ 
                                is_array(old("properties.{$specification->id}")) 
                                ? old("properties.{$specification->id}.{$property->id}") 
                                : (isset($product) ? $product->getPropertyById($property->id) : '')
                            }}">
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    @endif
</div>