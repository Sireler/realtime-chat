@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="row justify-content-center">

            <div class="col-md-10">
                <div class="row">
                    @include('layouts.menu_buttons')
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        @if (session()->has('avatar_status'))
                            <div class="alert alert-info">
                                {{ session()->get('avatar_status') }}
                            </div>
                        @endif
                        <img style="width: 200px; height: 200px; margin-bottom: 15px;" src="{{ asset( $user->avatar ) }}" alt="">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('changeAvatar') }}" class="form">
                            @csrf
                            <div class="custom-file">
                                <div class="form-group">
                                    <input name="avatar" required type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose avatar</label>
                                    @if ($errors->has('avatar'))
                                        <strong style="color: red">{{ $errors->first('avatar') }}</strong>
                                    @endif
                                </div>

                                <button class="btn btn-primary" type="submit">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
@endsection