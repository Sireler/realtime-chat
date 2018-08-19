@extends('layouts.app')

@section('content')
    <div id="notifies"></div>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>Profile</h3>
                    </div>
                    <div class="card-body">
                        asdads
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var myId = "{{ Auth::user()->id }}";
    </script>
@endsection