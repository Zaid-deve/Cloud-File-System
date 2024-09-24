$(function () {
    const fileDropArea = $('.upload-drop'),
        fileInput = $('#fileselinp');

    let toUploadFiles = [],
        totalBytes = 0,
        currHandler = null,
        isFilesCancelled = false,
        loadedBytes = 0;

    $('.btn-browse-files').click(function () {
        fileInput.trigger('click');
    });

    fileInput.on('change', function (ev) {
        prepareFiles(ev.target.files);
    });

    fileDropArea.on('dragover', ev => {
        ev.preventDefault();
        ev.stopPropagation();
        $(this).addClass('active');
    }).on("drop", ev => {
        ev.preventDefault();
        ev.stopPropagation();
        prepareFiles(ev.originalEvent.dataTransfer.files);
    });

    // Reusable function for showing file errors
    function showError(wrapper, message) {
        let progressText = wrapper.find('.progress-text'),
            progressIcon = wrapper.find('.progress-status');

        progressText.addClass('text-danger').text(message);
        progressIcon.html(`<i class="fa-solid fa-circle-exclamation icon-md danger-color"></i>`);
    }

    // Reusable function to handle file too large error
    function handleFileTooLarge(wrapper, file) {
        showError(wrapper, `File too large: ${file.name.slice(0, 30)}...`);
    }

    // Create progress wrapper 
    function createProgressWrapper(file) {
        if (file) {
            $(".progress-row").prepend(`
                <div class="col-md-6 col-lg-4 progress-wrapper" data-unqid="${file.unqId}">
                    <div class="bg-light-color rounded-3 p-3 h-100">
                        <div class="d-flex ycenter gap-3 h-100">
                            <div class="file-prev">
                                <i class="fa fa-solid fa-file file-icon"></i>
                            </div>
                            <div class="file-info">
                                <div class="fw-bold text-secondary file-name">${file.name}</div>
                                <small class="text-muted fw-bold progress-text">0 of ${formatBytes(file.size)}</small>
                            </div>
                            <div class="ms-auto">
                                <div class="progress-status">
                                    <small>waiting...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
            $(".progress-container").removeClass('d-none');
        }
    }

    // Handle files and remove invalid files
    function prepareFiles(files) {
        if (files && files.length) {
            let fs = Array.from(files);

            fs.forEach(f => {
                f.unqId = generateUniqueFileId(f);
                createProgressWrapper(f);

                let wrapper = $(`.progress-wrapper[data-unqid="${f.unqId}"]`);

                // Validate file size
                if (f.size > MaxFileUploadSize) {
                    handleFileTooLarge(wrapper, f);
                } else {
                    toUploadFiles.push(f);
                    totalBytes += f.size;
                }
            });

            if (toUploadFiles.length) {
                $('.total-progress-files').text(`0 of ${toUploadFiles.length}`);
                $('.total-progress-bytes').text(`(0 of ${formatBytes(totalBytes)})`);
                startUpload();
            } else {
                showErr('Nothing to upload !');
            }
        }
    }

    // Centralized function to cancel all files
    function cancelAllFiles(message) {
        $('.btn-cancel-all').hide();
        isFilesCancelled = true;

        if (currHandler) {
            currHandler.abort(); // Abort current file upload
            currHandler = null;
        }

        toUploadFiles.forEach(f => {
            if (f.status !== 'uploaded') {
                let wrapper = $(`.progress-wrapper[data-unqid="${f.unqId}"]`);
                showError(wrapper, message || 'Cancelled');
            }
        });

        $('.total-progress-files').text(`${toUploadFiles.filter(f => f.status === 'uploaded').length} of ${toUploadFiles.length}`);
        $('.total-progress-bytes').text(`(${formatBytes(loadedBytes)} of ${formatBytes(totalBytes)})`);
    }

    // Handle server error response
    function handleServerError(wrapper, errorMessage) {
        showError(wrapper, errorMessage);
    }

    async function startUpload() {
        if (!toUploadFiles.length) return;

        toUploadFiles = toUploadFiles.reverse();
        let uploadCount = 0;

        for (const f of toUploadFiles) {
            if (isFilesCancelled) break;

            let wrapper = $(`.progress-wrapper[data-unqid="${f.unqId}"]`),
                progressText = wrapper.find('.progress-text'),
                progressIcon = wrapper.find('.progress-status'),
                abortBtn;

            wrapper.addClass('active');

            let handler = await getUploadHandler(f);

            if (!(handler instanceof XMLHttpRequest)) {
                if (handler == 'ACCOUNT_LIMIT_ERR') {
                    showError(wrapper, 'Limit Reached');
                    handleServerError(wrapper, 'You have Exceeded Upload Limit Of 1 GB, go premium for the best !');
                    cancelAllFiles('Limit Reached !');
                    return;
                }

                showError(wrapper, 'Limit Reached !');
                handleServerError(wrapper, handler || 'Failed to upload file !');
                continue;
            }

            currHandler = handler;

            // Upload file progress
            handler.upload.onprogress = function (ev) {
                if (ev.lengthComputable) {
                    let { loaded, total } = ev;
                    let comp = (loaded / total) * 100;
                    let r = 13.5;
                    let circumference = 2 * Math.PI * r;
                    let strokeDashoffset = circumference - (circumference * comp / 100);

                    progressText.text(`${formatBytes(loaded)} of ${formatBytes(total)}`);

                    progressIcon.html(`
                            <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" class="progress-svg">
                                <circle cx="15" cy="15" r="${r}" fill="none" stroke="#E6E6E6" stroke-width="3" />
                                <circle cx="15" cy="15" r="${r}" fill="none" stroke="#28A745" stroke-width="3" 
                                    stroke-dasharray="${circumference}" stroke-dashoffset="${strokeDashoffset}"
                                    stroke-linecap="round" transform="rotate(-90 15 15)" />
                                <image href="../images/images-removebg-preview.png" x="2.5" y="2.5" width="25" height="25" class='abort-upload'/>
                            </svg>`);

                    abortBtn = wrapper.find('.abort-upload');
                    abortBtn.click(() => handler.abort());
                }
            };

            handler.onerror = handler.onabort = function (ev) {
                let errorType = ev.type === 'abort' ? 'Cancelled' : 'Failed';
                showError(wrapper, errorType);
            };

            handler.onload = function () {
                const r = JSON.parse(handler.response);
                loadedBytes += f.size;
                progressText.addClass('text-success').text('proccessing...');

                if (r.fileId) {
                    addFileMetaData(f, r.fileId, function (resp) {
                        const r = JSON.parse(resp);
                        if (r && r.Success) {
                            f.status = 'uploaded';
                            progressText.addClass('text-success').text('complete');
                            progressIcon.html(`<i class="fa-solid fa-circle-check icon-md text-success"></i>`);
                        } else {
                            if (r.Err === 'ACCOUNT_LIMIT_ERROR') {
                                showError(wrapper, 'Limit Reached !');
                                handleServerError(wrapper, "You have Exceeded Upload Limit Of 1 GB, go premium for the best !");
                                return;
                            }

                            showError(wrapper, 'Failed');
                            handleServerError(wrapper, r.Err || "Upload Failed");
                        }
                    });
                } else {
                    handleServerError(wrapper, r.error || 'Upload Failed');
                }
            };


            handler.send(f);

            await new Promise((resolve) => {
                handler.onloadend = resolve;
            });

            wrapper.removeClass('active');
            uploadCount++;

            $('.total-progress-files').text(`${uploadCount} of ${toUploadFiles.length}`);
            $('.total-progress-bytes').text(`(${formatBytes(loadedBytes)} of ${formatBytes(totalBytes)})`);
        }
        showMsg('Upload Complete!', 'success');
    }

    // Attach cancelAllFiles to "Cancel All" button
    $(".btn-cancel-all").click(function () {
        cancelAllFiles('Cancelled');
    });
});
