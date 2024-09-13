function showErr(err = "Something Went Wrong !") {
    $('.alert-container').prepend(`<div class="alert bg-danger-color alert-dismissible d-flex ycenter gap-3 text-light" role="alert">
                                       <i class="fa-solid fa-circle-exclamation icon-md"></i>
                                       <div class="fw-bold">${err}</div>
                                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="box-shadow: none;"></button>
                                   </div>`);

    let ref = $(".alert-container .alert").first();
    setTimeout(() => {
        if (ref.length) {
            ref.fadeOut(250, function () {
                ref.remove();
            })
        }
    }, 3000);
}

function showMsg(msg, badge = 'success') {
    $('.notify-container').prepend(` <div class="notify-badge bg-${badge ?? 'success'} d-flex ycenter gap-3 px-3 py-2 rounded-4 text-light">
                                          <i class="fa-solid fa-bell icon-normal"></i>
                                          <span class="fw-normal">${msg}</span>
                                          <button type="button" class="btn-close btn-close-white ms-auto" aria-label="Close" style="box-shadow: none;"></button>
                                      </div> `);

    let ref = $(".notify-container .notify-badge").first();
    setTimeout(() => {
        if (ref.length) {
            ref.fadeOut(250, function () {
                ref.remove();
            })
        }
    }, 3000);
}

function showPopup(popup) {
    if (popup) {
        let t = $(`.${popup}`);
        if (t.length) {
            $('.popup-container').removeClass('d-none');
            t.parent().removeClass('d-none');
        }
    }
}

function hidePopup() {
    $('.popup-container').addClass('d-none');
    $('.popup-container .popup').parent().addClass('d-none');
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 B';

    const units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        k = 1024,
        i = Math.floor(Math.log(bytes) / Math.log(k)),
        value = parseFloat((bytes / Math.pow(k, i)).toFixed(2));

    return `${value} ${units[i]}`;
}