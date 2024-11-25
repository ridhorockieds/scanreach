function deleteItem({
    element,
    url
}) {
    const el = $(element);
    const valueDelete = el.html();
    el.html('<i class="fas fa-spinner fa-spin mr-1"></i>');
    $.ajax({
        url: url,
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: () => {
            el.prop("disabled", true);
        },
        success: ({
            message,
            redirect
        }) => {
            successToast(message);
            if (redirect) setTimeout(() => window.location.href = redirect, 1500);
        },
        error: ({
            responseJSON
        }) => {
            if (responseJSON.errors) errorToast(Object.values(responseJSON.errors).flat()
                .join("<br>"));
            else errorToast(responseJSON.message);
            if (responseJSON.redirect) setTimeout(() => window.location.href = responseJSON
                .redirect, 1500);
        },
        complete: () => el.prop("disabled", false).html(valueDelete),
    });
}