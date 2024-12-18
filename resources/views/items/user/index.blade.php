@extends('layouts.app')

@section('title', 'Items')

@section('blockhead')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus mr-1"></i>
                Add Items
            </a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Items</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>QR Code</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ Str::limit($item->description, 70) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="showQRCode({ url: '{{ asset('storage/qrcodes/' . $item->qr_code_path) }}', name: '{{ $item->name }}' })">Show</button>
                                    </td>
                                    <td>
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('items.edit', $item->uuid) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteItem({element: this, url: '{{ route('items.destroy', $item->uuid) }}'})">
                                            <i class="fas fa-trash mr-1"></i>
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    @include('includes.modal-qrcode')
@endsection

@section('blockfoot')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets/js/items/show-qrcode.js') }}"></script>
    <script src="{{ asset('assets/js/items/delete-item.js') }}"></script>
    <script>
        $('.items').addClass('active');
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "searching": true,
            });
        });

        $('#download-button').on('click', function() {
            var gambar = $('#gambar');
            var link = document.createElement('a');
            link.href = gambar.src;
            link.download = '{{ $item->name ?? 'Item' }}' + '-' + '{{ $item->qr_code_path ?? 'Item' }}' + '.png';
            link.click();
        });
    </script>
@endsection
