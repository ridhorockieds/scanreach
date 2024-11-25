@extends('layouts.app')

@section('title', 'Edit Item')

@section('blockhead')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('items.update', $item->uuid) }}" method="post" id="mainForm"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Item Name</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Item Name" value="{{ $item->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" class="form-control" rows="2" placeholder="Description...">{{ $item->description }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                        id="image" value="{{ $item->image }}">
                                                    <label class="custom-file-label" for="image">Choose
                                                        file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <a href="{{ route('items.index') }}" class="btn btn-secondary mr-1">Back</a>
                                    <button type="reset" class="btn btn-warning mr-1">Reset</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
@endsection

@section('blockfoot')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $('.items').addClass('active');
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
