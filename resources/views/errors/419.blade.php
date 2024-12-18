@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    <h3><i class="fas fa-exclamation-triangle text-danger"></i> {{ __('Page Expired') }}</h3>
@endsection
