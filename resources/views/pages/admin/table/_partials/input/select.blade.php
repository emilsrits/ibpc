<select class="filter-input" name="{{ $name }}">
    <option value=""></option>
    @foreach($options as $value => $description)
        <option value="{{ $value }}" {{ request($name) === (string)$value ? 'selected' : '' }}>{{ $description }}</option>
    @endforeach
</select>