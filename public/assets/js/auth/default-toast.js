toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

function successToast(message) {
    toastr.success(message);
}

function errorToast(message) {
    toastr.error(message);
}

function infoToast(message) {
    toastr.info(message);
}

function warningToast(message) {
    toastr.warning(message);
}

function defaultToast(message) {
    toastr.info(message);
}