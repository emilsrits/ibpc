@if($table->paginated)
    {{ $collection->appends(Request::except('page'))->links() }}
@endif

<div>
    <table class="table entity-table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th style="width: 50px">
                    <input id="mass-select" type="checkbox" name="mass-select" value="yes">
                </th>

                @foreach($table->getColumns() as $item)
                    <th style="width: {{ $item['width'] }}">{{ $item['name'] }}</th>
                @endforeach

                <th style="width: 50px"></th>
            </tr>
        </thead>
        @if($table->hasFilters())
            <tr class="table-filters">
                <td></td>
                    @foreach($table->getColumns() as $item)
                        <td>{!! $item['filter'] ? $item['filter']->render() : '' !!}</td>
                    @endforeach
                <td></td>
            </tr>
        @endif
        <tbody>
            @foreach($collection as $entity)
                <tr>
                    <td>
                        <input class="entity-select" type="checkbox" name="{{ "{$table->slug}[{$entity->id}][id]" }}" value="{{ $entity->id }}">
                    </td>

                    @foreach($table->getColumns() as $item)
                        <td>{{ $entity[$item['column']] }}</td>
                    @endforeach

                    <td>
                        <a href="{{ url("/admin/{$table->slug}/edit", ['id' => $entity->id]) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($table->paginated)
    {{ $collection->appends(Request::except('page'))->links() }}
@endif

@section('scripts')
<script>
    // Check all checkboxes in table for mass action
    const massSelect = document.getElementById('mass-select');
    if (massSelect) {
        massSelect.addEventListener('click', function(event) {
            let entityCheckboxes = document.getElementsByClassName('entity-select');

            let isChecked = event.currentTarget.checked;
            
            for (let checkbox of entityCheckboxes) {
                if (isChecked) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            }
        });
    }
</script>
@endsection