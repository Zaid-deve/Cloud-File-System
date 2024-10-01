let displayFiles,
    displayFetchErr,
    checkAllBtn;

$(async function () {
    // components
    const allFilesBody = $(".all-files-body"),
        recentFilesContainer = $('.recent-files-container'),
        recentFilesBody = $('.recent-files-body');

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
                    fillContainers(false);
                    return;
                }

                $('.btn-check-all').removeClass('d-none');
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
                                        <div class="file-wrapper-prev d-flex flex-center position-relative" onclick='toggleCheck("${f.id}")'>
                                            <div class="file-wrapper-icon">
                                                <i class="fa-solid fa-file file-icon"></i>
                                            </div>
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
                                   </div>`

                    // display if its an recent file
                    if (isRecentFile) {
                        recentOutput += wrapper;
                    }

                    output += `<div class="col-sm-6 col-lg-4">
                                ${wrapper}
                               </div>`;
                })

                if (recentOutput) {
                    recentFilesBody.html(`<div class="d-flex gap-4 overflow-scroll">${recentOutput}</div>`)
                    recentFilesContainer.addClass('visible');
                    recentFilesContainer.removeClass("d-none");
                } else {
                    recentFilesContainer.hide();
                    recentFilesContainer.removeClass('visible');
                    recentFilesContainer.addClass("d-none");
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
            if (__Checked.size !== __Files.length) {
                toggleCheck(__Files.map(f => f.id), 'check');
            } else {
                toggleCheck(__Files.map(f => f.id), 'uncheck');
            }
        });

    } catch (e) {
        displayFetchErr(e.message);
    }
})

function toggleCheck(fileIds, action = 'toggle') {
    if (!Array.isArray(fileIds)) fileIds = [fileIds];

    fileIds.forEach(id => {
        let fileWrapper = $(`[data-fileid="${id}"]`),
            checkbox = fileWrapper.find('.file-check-inp'),
            checkIcon = fileWrapper.find('.check-icon'),
            isChecked = checkbox.prop('checked');

        if (action === 'toggle') {
            checkbox.prop('checked', !isChecked)
        } else if (action === 'check') {
            checkbox.prop('checked', true);
        } else if (action === 'uncheck') {
            checkbox.prop('checked', false);
        }

        if (checkbox.prop('checked')) {
            checkIcon.addClass("show");
            __Checked.add(id);
            fileWrapper.fadeTo(250, .5)
        } else {
            checkIcon.removeClass("show");
            fileWrapper.fadeTo(250, 1)
            __Checked.delete(id);
        }
    });

    if (__Checked.size == __Files.length) {
        checkAllBtn.find('span').text('select all');
    } else {
        checkAllBtn.find('span').text('un select all');
    }

}