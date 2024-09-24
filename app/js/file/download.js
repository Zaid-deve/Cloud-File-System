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
                addProgressWrapper(f);
                __Downloads.push(f);
            });

            updateStats()
            btnsContainer.removeClass('d-none');
            startDownload();
        }
    }

    function addProgressWrapper(file) {
        let unqId = generateUniqueFileId(file);
        file.unqId = unqId;
        file.status = 0;
        file.loaded = 0;

        const progressWrapper = $(`
            <div class="col-md-6">
                <div class="d-flex gap-3 bg-light rounded-2 py-2 ps-3 download-progress-wrapper" data-unqid="${unqId}">
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
        let pendingFiles = __Downloads.find(f => (f.status == 0 || f.status == 1));

        let totalFiles = pendingFiles.length,
            totalSize = totalFiles ? getPendingDownloadSize(pendingFiles) : 0,
            estimatedTime = totalSize / totalFiles * 1;

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
                    let handler = getDownloadHandler(f),
                        wrapper = $(`[data-unqid="${f.unqId}"]`)
                    try {
                        f.status = 1;
                        if (!handler) {
                            throw new Error('Failed to download file, please try again !');
                        }

                        // add handlers
                        await attachDownloadHandlers(handler, f, wrapper);

                        // success
                        wrapper.find('.btn-cancel-download').replaceWith('<i class="fa-solid fa-file-circle-check icon-md"></i>');
                    } catch (e) {
                        if (e.message == 'DOWNLOAD_ERR') {
                            f.status = -1;
                            wrapper.addClass('bg-warning');
                            wrapper.find('.file-progress').html(`<span class='text-danger'>${handler.readyState == 0 ? "cancelled" : "failed"}</span>`)
                            wrapper.find('.btn-cancel-download').replaceWith('<i class="fa-solid fa-triangle-exclamation icon-md text-danger"></i>');

                        } else {
                            showErr(e.message);
                        }
                    }
                    finally {
                        // updateStats();
                        console.log('Request Complete');
                    }
                }
            }
        }
    }

    function attachDownloadHandlers(xhr, file, wrapper) {
        return new Promise((resolve, reject) => {
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
