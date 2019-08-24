<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('message-' . $msg))
            <div class="message message-{{ $msg }}">
                <div class="message-text">{{ Session::get('message-' . $msg) }}</div>
                <div class="message-close">
                    <a href="#" data-dismiss="message" aria-label="message-close"><i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
            </div>
        @endif
    @endforeach
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>