$(function () {
    $(".btn-edit-profile").click(function () {
        let username = $('.username').text(),
            email = $('.useremail').text(),
            profile = $('.userprofile').prop('src');

        $('#edit-prev-img').prop('src', profile);
        $('#edit-email').val(email)

        showPopup('popup-update-profile');
        $('#edit-username').val(username).focus();
    })


    // display recent files
    let filesContainer = $('.recent-files-row');
    try {
        if (!data || !data.length) {
            throw new Error();
        }

        let output = '';

        data.forEach(f => {
            let fd = f.type.split('/'),
                fmime = fd[0],
                ftype = fd[1],
                pvWrapper = '';

            if (isImageFile(fmime, ftype)) {
                // Skeleton loader wrapper
                pvWrapper = `<div class='h-100 w-100 position-relative'>
                                <img src='${f.downloadUrl}' class='h-100 w-100 img-cover d-none' alt='Image' onload='$(this).removeClass("d-none").next().remove()'>
                                <div class="skeleton h-100 w-100"></div>
                             </div>`;
            } else {
                pvWrapper = `<div class="file-wrapper-icon">
                                <i class="${getFileIcon(ftype)} file-icon"></i>
                             </div>`;
            }

            let wrapper = `<div class="file-wrapper rounded-4 overflow-hidden border border-1" data-fileid="${f.id}" ondblclick='location.href = "/cfs/app/view/file.php?fileId=${f.id}"'>
                                    <div class="file-wrapper-prev d-flex flex-center position-relative" onclick='toggleCheck("${f.id}")'>
                                        ${pvWrapper}
                                        <input type='checkbox' class='file-check-inp' hidden>
                                        <div class='position-absolute z-1 top-0 start-0 h-100 w-100 p-3'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-folder-check check-icon fade" viewBox="0 0 16 16">
                                                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                                                <path d="M15.854 10.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.707 0l-1.5-1.5a.5.5 0 0 1 .707-.708l1.146 1.147 2.646-2.647a.5.5 0 0 1 .708 0"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="file-wrapper-body bg-light">
                                        <div class="d-flex ycenter justify-content-between py-1 px-3 gap-2">
                                            <p class="file-title text-muted fw-bold m-0">${f.name}</p>
                                            <button class="btn btn-rounded bg-white flex-shrink-0" onclick='showMenu(event)'>
                                                <i class="fa-solid fa-ellipsis text-dark"></i>
                                            </button>
                                        </div>
                                    </div>
                               </div>`;
            output += `<div class="col-sm-6 col-lg-4">
                                ${wrapper}
                           </div>`;
        });

        filesContainer.html(output);

    } catch(err) {
        alert(err);
        filesContainer.html(`<div class="text-center">
                                  <p class="text-muted">It looks like you havent uploaded any files recently, <br> start uploading files end-to-end encrypted</p>
                                  <div class="d-flex flex-center">
                                      <a href="/cfs/app/upload/upload.php" class="btn bg-secondary-color px-4 rounded-5 mt-3 has-icon">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-upload icon-svg" viewBox="0 0 16 16">
                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                          </svg>
                                          <span>Upload Files</span>
                                      </a>
                                  </div>
                             </div>`)
    }
})