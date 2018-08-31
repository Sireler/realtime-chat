@extends('layouts/app')

@section('content')
    <div class="content">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="form align-items-center" method="GET" action="{{ url('/find') }}">
                    <div class="input-group mb-3">
                        <input name="to" type="text" class="form-control" placeholder="Find user by username" aria-label="Find user by username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (!request('to'))
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($dialogs->isEmpty())
                    <div class="row justify-content-center">
                        <div class="col-8 alert alert-info">
                            Here are your last dialogs
                        </div>
                    </div>

                @endif
                @foreach($dialogs as $dialog)
                    <div class="alert alert-light dialog-item">
                        <img style="width: 32px; height: 32px; margin-right: 10px;" src="{{ asset($dialog->avatar) }}" alt="" class="rounded-circle">
                        <a href="{{ url('/chat?to=' . $dialog->id) }}">{{ $dialog->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if (request('to'))
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="row">
                    @include('layouts.menu_buttons')
                </div>


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
        @endif
    </div>
    </div>
    <script>

    </script>

@endsection