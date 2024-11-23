@extends('auth.layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('login') }}" method="post" id="mainForm">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-8">
         				<div class="icheck-primary">
							<input type="checkbox" id="remember">
							<label for="remember">
								Remember Me
							</label>
						</div>
					</div>
					<!-- /.col --> --}}
                    <div class="col-12 mb-2">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <!-- /.social-auth-links -->

            {{-- <p class="mb-1">
      			<a href="#">I forgot my password</a>
      		</p> --}}
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
