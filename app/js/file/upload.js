$(function () {
    const fileDropArea = $('.upload-drop'),
        fileInput = $('#fileselinp');

    let toUploadFiles = [],
        totalBytes = 0;

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
        prepareFiles(ev.originalEvent.dataTransfer.files)
    });

    // create progress wrapper 
    function createProgressWrapper(file) {
        if (file) {
            $(".progress-row").prepend(`
                <div class="col-md-6 col-lg-4 progress-wrapper" data-unqid="${file.uniqId}">
                    <div class="bg-light-color rounded-3 p-3 h-100">
                        <div class="d-flex ycenter gap-3 h-100">
                            <div class="file-prev">
                                <i class="fa fa-solifile-titled fa-file file-icon"></i>
                            </div>
                            <div class="file-info">
                                <div class="fw-bold text-secondary file-name">${file.name}</div>
                                <small class="text-muted fw-bold">0 of ${formatBytes(file.size)}</small>
                            </div>
                            <div class="ms-auto">
                                <div class="progress-status">
                                    <!-- <i class="fa-solid fa-circle-check icon-md text-success"></i> -->
                                    <!-- <i class="fa-solid fa-circle-exclamation icon-md danger-color"></i> -->
                                    <!-- <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg" class="progress-svg">
                                        <circle cx="15" cy="15" r="13.5" fill="none" stroke="#E6E6E6" stroke-width="3" />
                                        <circle cx="15" cy="15" r="13.5" fill="none" stroke="#28A745" stroke-width="3" stroke-dasharray="84.78" stroke-dashoffset="21.19" stroke-linecap="round" transform="rotate(-90 15 15)" />
                                        <image href="../images/images-removebg-preview.png" x="2.5" y="2.5" width="25" height="25" />
                                    </svg> -->
                                    <small>waiting...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`)
            $(".progress-container").removeClass('d-none')
            totalBytes += file.size;
        }
    }


    // handle files and remove invalid files
    function prepareFiles(files) {
        if (files && files.length) {

            let fs = Array.from(files);
            fs.filter(f => {
                // generate unique id
                f.unqId = generateUniqueFileId(f);

                // generate progress wrapper
                createProgressWrapper(f);

                if (f.size > MaxFileUploadSize) {
                    showErr(`File: ${f.name.slice(0, 30)}..., Could not be uploaded (Max upload size exceeded of 50 MB)`);
                }

                return f.size <= MaxFileUploadSize
            })

            toUploadFiles = fs;
            if (toUploadFiles) {
                $('.total-progress-files').text(`0 of ${toUploadFiles.length}`);
                $('.total-progress-bytes').text(`(0 of ${formatBytes(totalBytes)})`);
                startUpload();
            }
        } else {
            showErr('Nothing to upload !');
        }
    }

    async function startUpload() {
        if (toUploadFiles.length) {
            let i = 0;
            for (f of toUploadFiles) {
                let wrapper = $(".progress-wrapper").eq(i);
                wrapper.addClass('active')

                let handler = getUploadHandler(file);
                if(!handler){
                    showErr("Upload Failed");
                    continue;
                }

                await new Promise((r, rj) => {
                    setTimeout(() => {
                        r();
                    }, 4000);
                })

                wrapper.removeClass('active')
                i++
            }
        }
    }
})