@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Payment Required') }}</h3>
@endsection
    
