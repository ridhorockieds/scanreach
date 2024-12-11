const modalDelete = $('#modal-delete-user');
const buttonConfirmDelete = $('#delete-button');

function deleteUser({ el, url }) {
    modalDelete.modal('show');
    buttonConfirmDelete.attr('data-url', url);
}

buttonConfirmDelete.on('click', function () {
    let url = $(this).data('url');
    let textSubmit = $(this).html();
    $.ajax({
        url: url,
        method: 'Delete',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: () => $(this).prop("disabled", true).html(`<i class="fa fa-spinner fa-spin"></i>`),
        success: ({ message, redirect }) => {
            successToast(message);
            if (redirect) setTimeout(() => window.location.href = redirect, 1500);
        },
        error: ({ responseJSON }) => {
            if (responseJSON.errors) errorToast(Object.values(responseJSON.errors).flat().join("<br>")); else errorToast(responseJSON.message);
            if (responseJSON.redirect) setTimeout(() => window.location.href = responseJSON.redirect, 1500);
        },
        complete: () => $(this).prop("disabled", false).html(textSubmit),
    })
});