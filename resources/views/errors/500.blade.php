@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Server Error') }}</h3>
@endsection
