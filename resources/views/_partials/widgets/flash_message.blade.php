<widget-messages>
    @foreach(['danger', 'warning', 'success', 'info'] as $type)
        @if(Session::has('message-' . $type))
            <widget-messages-item
                :message-type="'{{ 'message-' . $type }}'"
                :message-content="'{{ session('message-' . $type) }}'"
            >
            </widget-messages-item>
        @endif
    @endforeach

    @if(count($errors) > 0)
        <widget-messages-item
            message-type="message-danger"
            :message-content="'{{ session('message-' . $type) }}'"
        >
            <template v-slot:message-content>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </template>
        </widget-messages-item>
    @endif
</widget-messages>