@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form class="form align-items-center" method="GET" action="{{ url('/find') }}">
                    <div class="input-group mb-3">
                        <input name="to" type="text" class="form-control" value="{{ request('to') }}" placeholder="Find user by username" aria-label="Find user by username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    @include('layouts.menu_buttons')
                </div>
                <div class="card">
                    <div class="card-body">
                        @if(session('find_status_not'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('find_status_not') }}
                            </div>
                        @endif
                        @if(session('find_status_found'))
                            <div class="alert alert-success" role="alert">
                                User found.<br>
                                {{ session('find_status_found') }}
                                <a href="{{ url('chat?to=' . $user[0]->id) }}">Chat</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection
