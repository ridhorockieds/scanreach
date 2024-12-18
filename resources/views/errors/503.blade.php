@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Service Unavailable') }}</h3>
@endsection
