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
        var myId = "{{ Auth::user()->id }}"

        var params = window
            .location
            .search
            .replace('?','')
            .split('&')
            .reduce(
                function(p,e){
                    var a = e.split('=');
                    p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                    return p;
                },
                {}
            );

        function sendMessage() {

            if ($('textarea').val() == '') {
                $('textarea').focus();
                return false;
            }

            var msgData = collectMsgData();
            var options = htmlMessage(msgData.content);

            sendAjaxData(msgData, options);


            $('textarea').val('');
            $('.no-messages-text').remove();


            $('ul.list-unstyled').prepend(
                options.obj
            );

            function collectMsgData() {
                let msg = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "to_id": params['to'],
                    "content": $('textarea').val()
                };

                return msg;
            }

            function htmlMessage(content) {
                let strDate = $('<div class="chat_time float-right">').text('Waiting...');
                let body = $('<div class="chat-body1 clearfix">');
                let p = $('<p class="rounded me">');
                let span = $('<span class="chat-img1 float-left">').append($($('#currUserAvatar')[0]).clone());
                let li = $('<li class="left clearfix">')
                    .append(span)
                    .append(body.append(p.text(content)).append(strDate));

                return {obj: li, time: strDate};
            }

            function sendAjaxData(obj, html) {
                let postURL = window.location.href.replace(window.location.search, '');

                $.post(postURL, obj, function(data) {
                    html.time.text(data.created_at);
                });
            }
        }

    </script>

@endsection