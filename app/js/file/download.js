let showDownloadPopup;

$(function () {
    const totalDownloads = $('.total-downloads'),
        totalDownloadSize = $('.total-download-size'),
        totalDownloadTime = $('.total-download-time'),
        downloadProgressContainer = $('.download-progress-container'),
        downloadProgressRow = downloadProgressContainer.find('.row'),
        btnsContainer = $('.download-btns'),
        btnPauseAll = $('.btn-pause-all'),
        btnCancelAll = $('.btn-cancel-all');

    showDownloadPopup = function (files) {
        if (files) {
            showPopup('popup-download');
            downloadProgressContainer.removeClass('d-none');

            files.forEach(f => {
                f.unqId = generateUniqueFileId(f);
                f.status = 0;
                f.loaded = 0;
                __Downloads.push(f);
                addProgressWrapper(f);
            });

            updateStats()
            btnsContainer.removeClass('d-none');
            startDownload();
        }
    }

    function addProgressWrapper(file) {
        const progressWrapper = $(`
            <div class="col-md-6">
                <div class="d-flex gap-3 bg-light rounded-2 py-2 ps-3 download-progress-wrapper" data-unqid="${file.unqId}">
                    <div class="file-icon">
                        <i class="fa-solid fa-file fs-1"></i>
                    </div>
                    <div>
                        <strong class="d-block file-name text-truncate" style='max-width:300px'>${file.name}</strong>
                        <small class="file-progress">0 Kb of ${formatBytes(file.size)}</small>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-close btn-lg btn-cancel-download"></button>
                    </div>
                </div>
            </div>
        `);
        downloadProgressContainer.removeClass('d-none');
        downloadProgressRow.append(progressWrapper);
    }

    function updateStats() {
        // pending files
        let pendingFiles = __Downloads.filter(f => (f.status == 0 || f.status == 1));

        let totalFiles = pendingFiles.length,
            totalSize = totalFiles ? getDownloadSize(pendingFiles) : 0,
            estimatedTime = 0;

        totalDownloads.text(totalFiles);
        totalDownloadSize.text(formatBytes(totalSize));
        totalDownloadTime.text(`${estimatedTime}s`);
    }

    function updateWrapper(wrapper, file) {
        wrapper.find('.file-progress').text(`${formatBytes(file.loaded)} of ${formatBytes(file.size)}`);
        if (file.loaded == file.size) {
            wrapper.find('.btn-cancel-download').remove();
        }
    }

    async function startDownload() {
        if (__Downloads && __Downloads.length) {
            let pendingFiles = __Downloads.filter(f => f.status == 0);
            if (pendingFiles.length) {
                for (let f of pendingFiles) {
                    let handler, wrapper;

                    try {
                        handler = getDownloadHandler(f)
                        wrapper = $(`[data-unqid="${f.unqId}"]`)

                        f.status = 1;
                        if (!handler) {
                            throw new Error('Failed to download file, please try again !');
                        }

                        file.handler = handler;

                        // add handlers
                        await attachDownloadHandlers(f, wrapper);

                        // success
                        wrapper.find('.btn-cancel-download').replaceWith('<i class="fa-solid fa-file-circle-check icon-md"></i>');
                    } catch (e) {
                        showErr(e.message == "DOWNLOAD_ERR" ? "Something Went Wrong !" : e.message);
                        f.status = -1;
                        f.handler = null;
                        f.loaded = 0;
                        wrapper.addClass('bg-warning');
                        wrapper.find('.file-progress').html(`<span class='text-danger'>${handler.readyState == 0 ? "cancelled" : "failed"}</span>`)
                        wrapper.find('.btn-cancel-download').replaceWith('<i class="fa-solid fa-triangle-exclamation icon-md text-danger"></i>');
                    }
                    finally {
                        // updateStats();
                        console.log('Request Complete');
                    }
                }
            }
        }
    }

    function attachDownloadHandlers(file, wrapper) {
        return new Promise((resolve, reject) => {
            let handler = file.handler;
            if (!handler) {
                reject('Failed to download file');
                return;
            }

            xhr.onprogress = function (event) {
                if (event.lengthComputable) {
                    file.loaded = event.loaded;
                    updateWrapper(wrapper, file);
                }
            };

            xhr.onabort = xhr.onerror = function () {
                reject('DOWNLOAD_ERR');
            };

            xhr.onload = function () {
                if (xhr.status === 200) {
                    file.status = 2;
                    file.loaded = file.size;
                    updateWrapper(wrapper, file);
                    showMsg('File Downloaded', "success");
                    resolve();
                } else {
                    reject(new Error('DOWNLOAD_ERR'));
                }
            };

            wrapper.find('.btn-cancel-download').click(function () {
                xhr.abort();
            })

            xhr.send();
        })
    }

});
