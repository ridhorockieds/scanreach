@extends('auth.layouts.auth')

@section('title', 'Verify')

@section('content')
  <div class="card">
      <div class="card-body register-card-body">
          <p class="login-box-msg">Verify your account</p>
          <p>Your account has not been verified. Please check your email for a verification code.</p>
        <form method="POST" action="{{ route('verification.resend') }}" id="mainForm">
            @csrf
            If you did not receive the email,
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">resend code</button>
        </form>

        <a class="btn btn-block btn-primary mt-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <!-- /.form-box -->
</div>
@endsection