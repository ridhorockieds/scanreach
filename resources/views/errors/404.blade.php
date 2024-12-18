@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Not Found') }}</h3>
@endsection
