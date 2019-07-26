@if($category)
    @if($category->specifications->first())
        <div class="content-section-toggle">
            <strong>Specifications<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
        </div>
        <div class="content-container">
            <table class="product-table">
                <tbody>
                @foreach($category->specifications as $key => $specification)
                    @if($specification->properties->first())
                        <tr class="entity-specification">
                            <td colspan="2">{{ $specification->name }}</td>
                        </tr>
                    @endif
                    @foreach($specification->properties as $property)
                        <tr class="entity-attribute">
                            <td><label for="{{ 'properties[' . $specification->id . '][' . $property->id . ']' }}">{{ $property->name }}</label></td>
                            <td><input type="text" 
                                    name="{{ 'properties[' . $specification->id . '][' . $property->id . ']' }}" 
                                    value="{{ is_array(old('properties.'.$specification->id)) ? old('properties.'.$specification->id.'.'.$property->id.'') : '' }}"></td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif