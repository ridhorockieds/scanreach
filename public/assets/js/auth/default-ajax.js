const form = $("#mainForm");
const url = form.attr("action");
const method = form.attr("method");
const buttonSubmit = form.find("button[type=submit]");
const textSubmit = buttonSubmit.text();

buttonSubmit.on("click", submitForm);

function submitForm() {
    $.ajax({
        url,
        method,
        data: form.serialize(),
        dataType: "json",
        beforeSend: () => buttonSubmit.prop("disabled", true).html(`<i class="fa fa-spinner fa-spin"></i>`),
        success: ({ message, redirect }) => {
            successToast(message);
            if (redirect) setTimeout(() => window.location.href = redirect, 1500);
        },
        error: ({ responseJSON }) => {
            if (responseJSON.errors) errorToast(Object.values(responseJSON.errors).flat().join("<br>")); else errorToast(responseJSON.message);
            if (responseJSON.redirect) setTimeout(() => window.location.href = responseJSON.redirect, 1500);
        },
        complete: () => buttonSubmit.prop("disabled", false).text(textSubmit),
    });
}

