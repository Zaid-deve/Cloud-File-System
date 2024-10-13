$(function () {

    try {

        if (!FILE) {
            throw new Error("File not provided");
        }

        FILE.data = null;
        if (!FILE.downloadUrl) {
            throw new Error();
        }

        __Files.push(FILE);

        let ft = FILE.type.split('/'),
            fmime = ft[0],
            ftype = ft[1];

        let previewContainer = $("#file-prev-container");
        previewContainer.empty();

        if (isTextFile(fmime, ftype)) {
            displayTextPreview(FILE, previewContainer);
        } else if (isImageFile(fmime, ftype)) {
            displayImagePreview(FILE, previewContainer);
        } else if (isVideoFile(fmime, ftype)) {
            displayVideoPreview(FILE, previewContainer);
        } else if (isAudioFile(fmime, ftype)) {
            displayAudioPreview(FILE, previewContainer);
        } else {
            displayNonPreviewable(FILE, previewContainer);
        }


        // can download file
        $("#btn-download-file").click(function () {
            $(".popup-download").addClass('working')
            showDownloadPopup(__Files);
            $(".popup-download").removeClass('working')
        })

        // can share file
        $("#btn-share-file").click(function () {
            showSharePopup(FILE.id);
        })

        // delete file
        $('#btn-delete-file').click(function () {
            $(this).addClass("working").prop('disabled', true);
            deleteFile([FILE.id], (r) => {
                if (r.Success) {
                    showMsg('File Deleted ', 'success');
                    location.replace('/cfs/app');
                    return;
                }

                showErr(r.Err);
                $(this).removeClass("working").prop('disabled', false);
            })
        })
    } catch (error) {
        showErr(error);
    } finally {
        console.log("Complete !");
    }

    function isTextFile(fmime, ftype) {
        return fmime === 'text' || ['txt', 'json', 'xml', 'html'].includes(ftype);
    }

    function isVideoFile(fmime, ftype) {
        let vidTypes = ['mp4', 'webm'];
        return fmime === 'video' && vidTypes.includes(ftype);
    }

    function isAudioFile(fmime, ftype) {
        let audioTypes = ['mp3', 'wav', 'ogg', 'mpeg'];
        return fmime === 'audio' && audioTypes.includes(ftype);
    }

    async function displayTextPreview(file, container) {
        let contents = await $.get(file.downloadUrl, function (data) {
            container.html(`<pre class="text-light p-3"></pre>`);
            container.find('pre').text(data);
            file.data = data;
        }).fail(f => { throw new Error() });
    }

    function displayImagePreview(file, container) {
        container.html(`<img src="${file.downloadUrl}" alt="${file.name}" class="img-contain h-100 w-100">`);
    }

    function displayVideoPreview(file, container) {
        container.html(`
            <video controls autoplay muted class="w-100 h-100 rounded shadow-sm">
                <source src="${file.downloadUrl}" type="${file.type}">
                Your browser does not support the video tag.
            </video>
        `);
    }

    function displayAudioPreview(file, container) {
        container.html(`
            <audio controls class="w-100">
                <source src="${file.downloadUrl}" type="${file.type}">
                Your browser does not support the audio element.
            </audio>
        `);
    }

    function displayNonPreviewable(file, container) {
        container.html(`<div class="card card-text-dark w-100" style="max-width: 18rem;">
                          <div>
                            <i class='fa-solid fa-file'></i>
                          </div>
                          <div class="card-body">
                            <p class='card-text'>no preview available for this file</p>
                            <p class="card-text">${file.visibility == '0' ? 'local file' : 'private file'}</p>
                          </div>
                        </div>`);
    }
});
