function showQRCode({ url, name }) {
    const modal = $('#modal-qrcode');
    const image = modal.find('img');
    image.attr('src', url);
    image.attr('alt', name);
    modal.modal('show');
}