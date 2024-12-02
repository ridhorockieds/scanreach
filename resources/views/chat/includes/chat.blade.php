<div class="content">
    <div class="container">
        <div class="card">
            <form action="{{ route('chat.send', $item->uuid) }}" method="post" id="mainForm"
                enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h3>Send Message to Owner</h3>
                    <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                    <input type="hidden" name="uuid" value="{{ $item->uuid }}">
                    <div class="form-group">
                        <input type="subject" name="subject" class="form-control" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="4" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <button type="reset" class="btn btn-block btn-warning mr-1">Reset</button>
                    <button type="submit" class="btn btn-block btn-primary">Send</button>
                </div>
            </form>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
