@extends('layouts.app')

@section('title', 'Notification Settings')

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Notification</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email <span class="text-muted text-xs font-italic font-weight-light d-none">Activated by default</span></label>
                                        <div class="form-group d-flex align-items-center ">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Fullname" value="{{ Auth::user()->email }}" disabled>
                                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success d-none">
                                                <input type="checkbox" class="custom-control-input" disabled checked id="switch-emaiil">
                                                <label class="custom-control-label" for="switch-emaiil"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="telegram">Telegram</label>
                                        <div class="form-group d-flex align-items-center">
                                            <input type="text" class="form-control mr-2" id="telegram" name="telegram" placeholder="1234567" value="{{ Auth::user()->id_telegram ?? '-' }}" disabled>
                                            <div class="custom-control custom-switch {{ !Auth::user()->id_telegram ?? 'custom-switch-off-danger custom-switch-on-success' }} d-none">
                                                <input type="checkbox" class="custom-control-input" {{ Auth::user()->id_telegram ?? 'disabled'}} id="switch-telegram">
                                                <label class="custom-control-label" for="switch-telegram"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="whatsapp">WhatsApp <span class="text-muted text-xs font-italic font-weight-light">Coming soon</span></label>
                                        <div class="form-group d-flex align-items-center">
                                            <input type="text" class="form-control mr-2" id="whatsapp" name="whatsapp" placeholder="https://wa.me/62812345678" disabled>
                                            <div class="custom-control custom-switch d-none">
                                                <input type="checkbox" class="custom-control-input" disabled id="switch-whatsapp">
                                                <label class="custom-control-label" for="switch-whatsapp"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sms">SMS <span class="text-muted text-xs font-italic font-weight-light">Coming soon</span></label>
                                        <div class="form-group d-flex align-items-center">
                                            <input type="text" class="form-control mr-2" id="sms" name="sms" placeholder="+62812345678" disabled>
                                            <div class="custom-control custom-switch d-none">
                                                <input type="checkbox" class="custom-control-input" disabled id="switch-sms">
                                                <label class="custom-control-label" for="switch-sms"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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