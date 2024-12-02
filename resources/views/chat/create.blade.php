@extends('chat.layouts.app')

@section('title', 'Chat')

@section('content')
    <div class="lockscreen-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @include('chat.includes.images')
                </div>
                <div class="col-12 col-md-6">
                    @include('chat.includes.chat')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('blockfoot')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
