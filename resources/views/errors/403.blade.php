@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Forbidden') }}</h3>
@endsection
