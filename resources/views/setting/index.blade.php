@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
        <div class="row">
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-key"></i></span>
					<div class="info-box-content">
						<a href="{{ route('setting.account') }}" class="font-weight-bold">Account</a>
						<span class="text-muted">Manage account security and information.</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			@if (Auth::user()->hasRole('user'))
				<div class="col-12 col-sm-6 col-md-4">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bell"></i></span>
						<div class="info-box-content">
							<a href="{{ route('setting.notification') }}" class="font-weight-bold">Notification</a>
							<span class="text-muted">Select the kinds of notifications.</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			@endif
			<div class="col-12 col-sm-6 col-md-4">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-success elevation-1"><i class="fas fa-palette"></i></span>
					<div class="info-box-content">
						<a href="#" class="font-weight-bold">Preference <span class="text-muted text-xs font-italic font-weight-light">Coming soon</span></a>
						<span class="text-muted">Manage theme, color, and background.</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
        </div>
        <!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@section('blockfoot')
<script>
    $(document).ready(function() {
        $('.setting').addClass('active');
    });
</script>
@endsection
