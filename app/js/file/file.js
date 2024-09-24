let displayFiles,
    displayFetchErr,
    checkStrict;

$(async function () {
    // components
    const allFilesBody = $(".all-files-body"),
        recentFilesContainer = $('.recent-files-container'),
        recentFilesBody = $('.recent-files-body'),
        checkAllBtn = $(".btn-check-all");

    // to display files fething error
    displayFetchErr = function (err) {
        if (err == "PASS_KEY_ERR") {
            location.replace('safe.php?err=1');
            return;
        }

        if (err == "NO_SET_PASS_KEY") {
            showPopup('popup-set-passkey');
            return;
        }

        recentFilesContainer.hide();
        allFilesBody.html(`
                    <div class="p-4 text-center">
                        <img src="/cfs/app/images/fetch_err.png" alt="#" height="180" class="img-contain mx-auto">
                        <h3 class="mt-3 text-danger">Something Went Wrong !</h3>
                        <small>${err || 'Failed to fetch files, please try again'}</small>
                        <div class="d-flex flex-center">
                            <a href="./" class="btn bg-prime-color px-4 rounded-5 mt-3 has-icon">
                                <i class="fa-solid fa-rotate-right"></i>
                                <span>Retry</span>
                            </a>
                        </div>
                    </div>`)
    }

    try {

        let er = getParam('err');
        if (er) {
            $("#enter-passkey-inp").next().text('Please enter a valid passkey');
        }

        // fetch files
        let options = { success: prepareFiles, error: displayFetchErr, fileType: 'public' };
        if (currPage == 'safe.php') {
            if (!ISPASSKEYSET) {
                throw new Error('NO_SET_PASS_KEY');
                return;
            }

            let passkey = await requestPasskey();
            if (passkey) {
                options.passKey = passkey;
                options.fileType = 'private';
            } else {
                throw new Error();
            }

        } else if (currPage == 'share.php') {
            let data = getParam('data');
            if (!data) {
                throw new Error();
            }

            options.data = data;
            options.fileType = 'shared';
        }

        fetchFiles(options);

        // to preapre files
        function prepareFiles(files) {
            if (options.fileType == 'private') {
                CURRENT_USER_PASSKEY = $("#enter-passkey-inp").val();
                $("#enter-passkey-inp").val('');
            }

            if (files && Array.isArray(files)) {
                __Files = files.map(f => {
                    let perms = f.perms.split('');
                    return {
                        ...f, perms: { read: perms.includes('r'), write: perms.includes('w') }
                    };
                });

                if (currPage == 'share.php') {
                    $(".shared-files-count").text(`Shared ${files.length} Files To You.`)
                }

                if (files.length == 0) {
                    recentFilesContainer.hide();
                    allFilesBody.html(`<div class="p-4 text-center">
                                       <img src="/cfs/app/images/nofiles (2).png" alt="#" height="180" class="img-contain mx-auto">
                                       <h3 class="mt-3">No Files Yet !</h3>
                                       <small>It looks like you dont have files to show heare, <br> start uploading files end-to-end encrypted</small>
                                       <div class="d-flex flex-center">
                                           <a href="/cfs/app/upload/upload.php" class="btn bg-prime-color px-4 rounded-5 mt-3 has-icon">
                                               <i class="fa-solid fa-upload"></i>
                                               <span>Upload Files</span>
                                           </a>
                                       </div>
                                   </div>`);
                    return;
                }

                displayFiles(files);
            } else {
                displayFetchErr();
            }
        }



        // to display files
        displayFiles = function (files) {
            if (files) {
                let output = `<div class="row row-gap-4">`,
                    recentOutput = '',
                    isRecentFile;


                files.forEach(f => {
                    isRecentFile = isRecent(Date.parse(f.recent));
                    let wrapper = `<div class="file-wrapper rounded-4 overflow-hidden border border-1" data-fileid="${f.id}" data-source="${isRecentFile ? 0 : 1}">
                                   <div class="file-wrapper-prev d-flex flex-center position-relative">
                                       <div class="file-wrapper-icon">
                                           <i class="fa-solid fa-file file-icon"></i>
                                       </div>
                                       <div class="file-sel-body position-absolute top-0 start-0 w-100 h-100 p-3" data-checked="false" onclick='checkWrapper(event)'>
                                            <i class="fa-solid fa-file-circle-check icon-md prime-color check-icon fade"></i>
                                       </div>
                                   </div>
                                   <div class="file-wrapper-body bg-light">
                                       <div class="d-flex ycenter justify-content-between py-2 px-3 gap-2">
                                           <p class="file-title text-muted fw-bold m-0">${f.name}</p>
                                           <button class="btn btn-rounded bg-white flex-shrink-0" onclick='showMenu(event)'>
                                               <i class="fa-solid fa-ellipsis text-dark"></i>
                                           </button>
                                       </div>
                                   </div>
                               </div>`

                    // display if its an recent file
                    if (isRecentFile) {
                        recentOutput += wrapper;
                    }

                    output += `<div class="col-md-6 col-lg-4">
                            ${wrapper}
                           </div>`;
                })


                if (recentOutput) {
                    recentFilesBody.html(`<div class="d-flex gap-4 overflow-scroll">${recentOutput}</div>`)
                    recentFilesContainer.addClass('visible');
                } else {
                    recentFilesContainer.hide();
                    recentFilesContainer.removeClass('visible');
                }

                output + '</div>'
                allFilesBody.html(output);
            }

            fillContainers(currPage == 'share.php');
        }

        // check if file is recent
        function isRecent(timestamp) {
            if (timestamp) {
                return (Date.now() - timestamp) < 86400000;
            }
        }


        // select all files
        checkAllBtn.click(function () {
            if (__Files.length !== __Checked.size) checkStrict = true;
            $(".file-wrapper .file-sel-body").click();
            checkStrict = false;
        })
    } catch (e) {
        displayFetchErr(e.message);
    }
})

function checkWrapper(ev) {
    let fileId = ev.target.closest('.file-wrapper').dataset.fileid
    if (fileId) {
        let t = $(ev.target);
        if (!t.data('checked') || checkStrict) {
            t.addClass('checked');
            t.data('checked', true);
            t.find('.check-icon').addClass('show');
            __Checked.add(fileId);
        } else {
            t.data('checked', false);
            t.removeClass('checked')
            t.find('.check-icon').removeClass('show');
            __Checked.delete(fileId);
        }
    }
}