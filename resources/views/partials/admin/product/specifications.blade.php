@if($category)
    @if($category->specifications->first())
        <div class="content-section-toggle">
            <strong>Specifications<i class="fa fa-angle-up" aria-hidden="true"></i></strong>
        </div>
        <div class="content-container">
            <table class="product-table">
                <tbody>
                @foreach($category->specifications as $key => $specification)
                    @if($specification->attributes->first())
                        <tr class="entity-specification">
                            <td colspan="2">{{ $specification->name }}</td>
                        </tr>
                    @endif
                    @foreach($specification->attributes as $attribute)
                        <tr class="entity-attribute">
                            <td><label for="{{ 'attr[' . $specification->id . '][' . $attribute->id . ']' }}">{{ $attribute->name }}</label></td>
                            <td><input type="text" 
                                    name="{{ 'attr[' . $specification->id . '][' . $attribute->id . ']' }}" 
                                    value="{{ is_array(old('attr.'.$specification->id)) ? old('attr.'.$specification->id.'.'.$attribute->id.'') : '' }}"></td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif