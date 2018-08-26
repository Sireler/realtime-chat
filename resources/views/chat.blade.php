@extends('layouts/app')

@section('content')
    <div class="content">
        <div id="notifies"></div>

        <div class="row justify-content-center">
            <div class="col-2">
                <ul class="list-group">
                    @foreach ($users as $user)
                        <li class="list-group-item">
                            <a href="{{ route('chat', ['to' => $user->id]) }}">{{ $user->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Chat</h3>
                        @if (isset($userTo))
                            <div>
                                <span class="chat-username">{{ $userTo->name }}</span>
                                <span class="chat-img float-left">
                                    <img id="chat-to-user-avatar" src="{{ asset($userTo->avatar) }}" alt="User Avatar" class="rounded-circle">
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">

                        <div class="chat_area scroll">
                            <ul class="list-unstyled">
                                @if ($messages->isEmpty())
                                    <div class="no-messages-text">There is no messages...</div>
                                @endif
                                @foreach ($messages as $message)
                                    <li class="left clearfix">
                                    <span class="chat-img1 float-left">

                                        @if ($message->to_id == $userTo->id)
                                            <img src="{{ asset($message->fromUser->avatar) }}" alt="User Avatar" class="to rounded-circle">
                                        @else
                                            <img alt="User Avatar" src="{{ asset($message->fromUser->avatar) }}" class="rounded-circle from">
                                        @endif

                                    </span>
                                        <div class="chat-body1 clearfix">
                                            @if ($message->to_id == $userTo->id)
                                                <p class="rounded me">{{ $message->content }}</p>
                                            @else
                                                <p class="rounded">{{ $message->content }}</p>
                                            @endif

                                            <div class="chat_time float-right">
                                                {{ $message->created_at->format('jS F Y H:i') }}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="message_write">

                            <input id="to_id" hidden type="text" name="to_id" value="{{ $userTo->id }}">
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