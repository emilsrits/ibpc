@php if (!isset($category)) $category = null; @endphp
<table class="table is-striped">
    @foreach($specifications->chunk(3) as $chunk)
        <tr>
            @foreach($chunk as $specification)
                <td class="no-wrap">
                    <div class="field">
                        <input
                            id="{{ "spec[{$specification->id}][id]" }}"
                            class="switch is-small"
                            type="checkbox"
                            name="{{ "spec[{$specification->id}][id]" }}"
                            value="{{ $specification->id ?? '' }}"
                            {{ old("spec.{$specification->id}", optional($category)->getSpecificationById($specification->id)) ? 'checked' : '' }}>

                        <label for="{{ "spec[{$specification->id}][id]" }}">{{ $specification->slug }}</label>
                    </div>
                </td>
            @endforeach
        </tr>
    @endforeach
</table>