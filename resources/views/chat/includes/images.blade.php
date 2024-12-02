<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <img class="card-img-top" src="{{ asset('storage/items/' . $item->image) }}" alt="{{ $item->name }}">
                <h2>{{ $item->name }}</h2>
                <p>{{ $item->description }}</p>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
