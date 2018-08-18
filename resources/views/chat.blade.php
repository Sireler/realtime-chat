@extends('layouts/app')

@section('content')
    <div class="content">
        <div id="notifies"></div>

        <div class="row justify-content-center">
            <div class="col-2">
                <ul class="list-group">
                    @foreach ($users as $user)
                        <li class="list-group-item">
                            <a href="{{ url('/', ['to' => $user->id]) }}">{{ $user->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Chat</h3>
                        {{--User info--}}
                    </div>
                    <div class="card-body">

                        <div class="chat_area scroll">
                            <ul class="list-unstyled">
                                @if ($messages->isEmpty())
                                    <div class="no-messages-text">There is no messages...</div>
                                @endif
                                {{--Messages--}}
                            </ul>
                        </div>
                        <div class="message_write">

                            <input id="to_id" hidden type="text" name="to_id" value="{{ $to }}">
                            <textarea name="content" class="form-control" placeholder="type a message"></textarea>
                            <div class="clearfix"></div>
                            <div class="chat_bottom">
                                <button onclick="sendMessage()" id="send-message-btn" value="Send" class="pull-right btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>

    </script>

@endsection