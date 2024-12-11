@extends('layouts.app')

@section('title', 'Users Detail')

@section('blockhead')
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('users.update', $user->id) }}" method="post" id="mainForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="fullname">Fullname</label>
                                            <input type="text" name="fullname" class="form-control" id="fullname"
                                                placeholder="Fullname" value="{{ $user->fullname }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control" id="email"
                                                placeholder="email" value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" class="form-control" id="email"
                                                placeholder="email" value="{{ $user->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                <input type="checkbox" class="custom-control-input" disabled id="status" {{ $user->status == 'active' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status">{{ $user->status == 'active' ? 'Active' : 'Inactive' }}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="created_at">Created</label>
                                            <input type="text" name="created_at" class="form-control" id="created_at"
                                                placeholder="created_at" value="{{ $user->created_at->format('Y-m-d H:i:s') }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="updated_at">Last Update</label>
                                            <input type="text" name="updated_at" class="form-control" id="updated_at"
                                                placeholder="updated_at" value="{{ $user->updated_at->format('Y-m-d H:i:s') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary mr-1">Back</a>
                                    <button type="reset" class="btn btn-warning mr-1">Reset</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('blockfoot')
    <script>
        $('.users').addClass('active');
    </script>
@endsection
