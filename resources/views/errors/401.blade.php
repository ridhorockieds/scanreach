@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Unauthorized') }}</h3>
@endsection
