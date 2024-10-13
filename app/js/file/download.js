// download manager file to download files

let showDownloadPopup;

$(function () {
    const downloadProgressContainer = $('.download-progress-container'),
        downloadProgressRow = downloadProgressContainer.find('.row'),
        totalDownloads = $('.total-downloads'),
        totalDownloadSize = $('.total-download-size'),
        totalDownloadTime = $('.total-download-time'),
        downloadBtns = $('.download-btns'),
        cancelAllBtn = $('.btn-cancel-all-downloads')


    let downloadActive;

    // downloaded states
    const downloadStatus = {
        CANCELLED: -1,
        WAITING: 0,
        DOWNLOADING: 1,
        DOWNLOADED: 3
    };

    showDownloadPopup = function (files) {
        showPopup('popup-download');
        if (files) {
            files.forEach(f => {
                f.dnldid = generateUniqueFileId(f);
                f.status = downloadStatus.WAITING;
                f.loaded = 0;

                addDownloadItem(f);
                __Downloads.push(f);
            })

            updateStats();
            if (currPage != 'file.php') {
                toggleCheck(files.map(fl => fl.id), 'uncheck');
            }
            if (!downloadActive) {
                downloadFiles();
            }
        }
    }

    function updateStats() {
        let stats = getPendingDownloads();

        totalDownloads.text(stats.files.length);
        totalDownloadSize.text(formatBytes(stats.size));
        totalDownloadTime.text((stats.estTime + Math.random() * 1 * stats.files.length).toFixed(0) + "ms");

        if (stats.files.length) {
            downloadBtns.removeClass('d-none')
        } else {
            downloadBtns.removeClass('d-none')
        }

        if (!downloadProgressRow.find('.dnld-wrapper').length) {
            downloadProgressRow.html(`<div class="col-12 text-center">
                                        <img src="/cfs/app/images/nodnlds.png" alt="#" class="img-contain" width="180">
                                        <h3 class="mt-2 mb-1">Nothing To Download !</h3>
                                        <small class="text-muted">Downloads are easy and convinent on our site</small>
                                      </div>`);
        }
    }

    async function downloadFiles() {

        let toRemove = [];
        downloadActive = true;
        for (const f of __Downloads) {
            if (f.status !== downloadStatus.WAITING) {
                continue;
            }

            await downloadFile(f);
            toRemove.push(f);
        }

        removeFiles(toRemove);
        downloadActive = false;

    }

    async function downloadFile(f) {
        let handler,
            wrapper;

        try {

            handler = getDownloadHandler(f);
            if (!handler) {
                throw new Error();
            }
            f.handler = handler;

            wrapper = $(`[data-dnldid="${f.dnldid}"]`);
            wrapper.prependTo(downloadProgressRow);
            let progressBar = wrapper.find('.progress-bar'),
                statusTxt = wrapper.find('.dnld-progress');

            await attachDownloadHandlers(f, (ev) => {
                updateDownloadItem(ev, f, progressBar, statusTxt)
            });

            f.status = downloadStatus.DOWNLOADED;
            saveFile(f, handler.response);
            console.log('file downloaded');
            setWrapper(wrapper, f);
        } catch {
            setWrapper(wrapper, f);
            f.loaded = 0;
            f.status = -1;
        } finally {
            updateStats();
            wrapper = null;
            handler = null;
        }

    }

    function addDownloadItem(f) {
        const downloadItem = `
            <div class="col-md-6 overflow-hidden dnld-wrapper" data-dnldid="${f.dnldid}">
                <div class="d-flex gap-3 align-items-center bg-light rounded-3 py-2 ps-3">
                    <div class="file-icon">
                        <i class="fa-solid fa-file fs-2"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="dnwld-file-name m-0 fs-6">${f.name}</div>
                        <p class="text-muted mb-2 dnld-progress">0 of ${formatBytes(f.size)}</p>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-danger-color rounded-5" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class='dnld-btns'>
                        <button class="btn btn-close btn-cancel-download" title="Cancel Download"></button>
                    </div>
                </div>
            </div>
        `;

        if (!downloadProgressRow.find(`.dnld-wrapper`).length) {
            downloadProgressRow.empty();
        }

        downloadProgressRow.append(downloadItem);
        downloadProgressContainer.removeClass('d-none')
        downloadBtns.removeClass('d-none')

        let wrapper = downloadProgressRow.children().last();
        wrapper.find('.btn-cancel-download').click(function (ev) {
            ev.stopPropagation();
            cancelFile(f, false);
        })

    }

    function attachDownloadHandlers(f, progressCallback = null) {
        return new Promise((resolve, reject) => {
            if (f && f.status !== 1) {

                if (f.status === downloadStatus.CANCELLED || f.status === downloadStatus.PAUSED || f.status === downloadStatus.DOWNLOADING) {
                    reject();
                }

                let handler = f.handler;
                if (!handler || handler.readyState == XMLHttpRequest.DONE) {
                    reject();
                }

                handler.onprogress = function (ev) {
                    if (ev.lengthComputable) {
                        if (typeof progressCallback == "function") {
                            progressCallback(ev);
                        }
                    }
                }

                handler.onerror = handler.onabort = function (ev) {
                    reject();
                }

                handler.onload = function () {
                    handler.status == 200 ? resolve() : reject();
                }

                handler.send();
                f.status = downloadStatus.DOWNLOADING;

            } else {
                reject()
            }
        })
    }

    function updateDownloadItem(ev, f, progressBar, statusText) {
        if (ev.lengthComputable) {
            const comp = (ev.loaded / f.size) * 100;
            progressBar.css('width', `${comp}%`).attr('aria-valuenow', comp);
            statusText.text(`${formatBytes(ev.loaded)} of ${formatBytes(f.size)}`);
        }
    }

    function setWrapper(wrapper, f) {
        if (wrapper && f) {
            let status = f.status,
                statusTxt = wrapper.find('.dnld-progress'),
                wrapperBtns = wrapper.find('.dnld-btns');

            if (status == downloadStatus.DOWNLOADING) {
                statusTxt.text(`${formatBytes(f.loaded)} of ${formatBytes(f.size)}`);
                wrapperBtns.html(`<button class="btn btn-close btn-cancel-download" title="Cancel Download"></button>`);
            } else if (status == downloadStatus.CANCELLED) {
                statusTxt.text(`Cancelled`);
                wrapperBtns.html(`<button class="btn btn-retry-download" title="Retry Download"><i class="fa-solid fa-rotate-right prime-color icon-md"></i></button>`);
            } else if (status == downloadStatus.DOWNLOADED) {
                wrapperBtns.html(`<i class="fa-solid fa-circle-check me-3 text-success icon-md"></i>`);
            }

        }
    }

    function cancelFile(file, removeWrapper = true) {
        if (file.status == 3) {
            return;
        }

        file.status = -1;
        file.data = ''
        if (file.handler) {
            file.handler.abort();
        }

        let wrapper = $(`[data-dnldid='${file.dnldid}']`);
        if (removeWrapper) {
            wrapper.remove();
        }

        updateStats();
    }

    function removeFiles(files) {
        files.forEach(f => {
            let i = __Downloads.findIndex(fl => fl.dnldid == f.dnldid);
            if (i !== -1) {
                __Downloads.splice(i, 1);
            }
        })
    }

    cancelAllBtn.click(function () {
        downloadBtns.addClass('d-none');
        __Downloads.forEach(f => {
            cancelFile(f, true);
        })

        __Downloads = [];
    })
})