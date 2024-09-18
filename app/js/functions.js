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
    let t = $('.popup-container .popup');
    if (t.hasClass('working')) {
        return;
    }

    $('.popup-container').addClass('d-none');
    t.parent().addClass('d-none');
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 B';

    const units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        k = 1024,
        i = Math.floor(Math.log(bytes) / Math.log(k)),
        value = parseFloat((bytes / Math.pow(k, i)).toFixed(2));

    return `${value} ${units[i]}`;
}

function fillContainers() {
    if (!$('.recent-files-body .file-wrapper').length) {
        $('.recent-files-body').hide();
    }

    if (!$('.all-files-body .file-wrapper').length) {
        $('.all-files-body').html(`<div class="p-4 text-center">
                                           <img src="images/nofiles (2).png" alt="#" height="180" class="img-contain mx-auto">
                                           <h3 class="mt-3">No Files Yet !</h3>
                                           <small>It looks like you dont have files to show heare, <br> start uploading files end-to-end encrypted</small>
                                           <div class="d-flex flex-center">
                                               <a href="upload/upload.php" class="btn bg-prime-color px-4 rounded-5 mt-3 has-icon">
                                                   <i class="fa-solid fa-upload"></i>
                                                   <span>Upload Files</span>
                                               </a>
                                           </div>
                                       </div>`);
    }

    if (!__Files.length) {
        $('.btn-check-all').hide();
    }
}


function removeWrapper(data) {
    if (data) {
        if (typeof data === 'string') {
            data = [data];
        }
        else {
            data = Array.from(data);
        }

        data.forEach(f => {
            let t = $(`[data-fileid="${f}"]`)
            if (t.length) {
                if (t.data('source') == '1') {
                    t.parent().fadeOut(200, () => {
                        t.parent().remove();
                        fillContainers();
                    });
                }
                else {
                    t.fadeOut(200, () => t.remove());
                    fillContainers();
                }
            }
        })
    }
}


function getWrapper(fileId) {
    return $(`[data-fileid="${fileId}"]`);
}

function getParam(param){
    let us = new URLSearchParams(location.search);
    return us.get(param);
}