@extends('layouts.admin')

@section('title')
Orders
@endsection

@section('content')
<div class="section">
    <div class="container is-fluid">
        <div class="box">
            <h1 class="is-size-5">Order List</h1>

            <table-form
                action="{{ url('/admin/orders') }}"
            >
                <template v-slot:select-options>
                    @foreach(config('constants.order_status') as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </template>

                <template v-slot:entity-table>
                    {!! $table->render($orders) !!}
                </template>
            </table-form>
        </div>
    </div>
</div>
@endsection