let displayFiles,
    displayFetchErr;

$(function () {

    // components
    const allFilesBody = $(".all-files-body"),
        recentFilesContainer = $('.recent-files-container'),
        recentFilesBody = $('.recent-files-body')

    try {

        // fetch files
        fetchFiles({ success: prepareFiles, error: displayFetchErr });


        // to preapre files
        function prepareFiles(files) {
            if (files && Array.isArray(files)) {
                __Files = files;
                if (files.length == 0) {
                    recentFilesContainer.hide();
                    allFilesBody.html(`<div class="p-4 text-center">
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
                    recentOutput = '';
                files.forEach(f => {
                    let wrapper = `<div class="file-wrapper rounded-4 overflow-hidden bg-light-color border border-1" data-fileid="${f.id}"'>
                               <div class="file-wrapper-prev d-flex flex-center">
                                   <div class="file-wrapper-icon">
                                       <i class="fa-solid fa-file file-icon"></i>
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
                    if (f.recent) {
                        if (isRecent(Date.parse(f.recent))) {
                            recentOutput += wrapper;
                        }
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
        }

        // check if file is recent
        function isRecent(timestamp) {
            if (timestamp) {
                return (Date.now() - timestamp) < 86400000;
            }
        }
    } catch {
        displayFetchErr();
    }

    // to display files fething error
    displayFetchErr = function (err) {
        recentFilesContainer.hide();
        allFilesBody.html(`
                        <div class="p-4 text-center">
                            <img src="images/fetch_err.png" alt="#" height="180" class="img-contain mx-auto">
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
})