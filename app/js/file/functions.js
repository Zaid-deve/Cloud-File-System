function isImg(file) {
    const imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    return file && imageTypes.includes(file.type);
}

function generateUniqueFileId(file) {
    const rdig = Math.floor(Math.random() * 1000),
        fileName = file.name.replace(/\s+/g, '');

    return `${fileName}_${file.size}_${Date.now()}_${rdig}`;
}

/**
 * GENERAL UPLOAD FILE FUNCTIONS
 */

// Convert getUploadUrl to return a Promise
async function getUploadUrl(file) {
    let response;

    if (file) {
        let data = { fileName: file.name, fileSize: file.size };
        await $.post(`${baseurl}/app/php/b2/getUploadUrl.php`, data, function (resp) {
            response = JSON.parse(resp);
        })
    }

    return response;
}

// Updated getUploadHandler to work with async/await
async function getUploadHandler(file) {
    const resp = await getUploadUrl(file);

    if (resp?.Success && resp?.Data) {
        var uploadUrl = resp.Data;
    } else {
        return resp?.Err;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', uploadUrl.uploadUrl);

    xhr.setRequestHeader('Authorization', uploadUrl.authorizationToken);
    xhr.setRequestHeader('X-Bz-File-Name', encodeURIComponent(file.name));
    xhr.setRequestHeader('Content-Type', file.type);
    xhr.setRequestHeader('X-Bz-Content-Sha1', 'do_not_verify');

    return xhr;
}

// Add metadata after the file is successfully uploaded
async function addFileMetaData(file, fileId, callback) {
    if (file && fileId) {
        const fileData = {
            fileName: file.name,
            fileSize: file.size,
            fileType: file.type,
            fileId: fileId
        };

        $.post(`${baseurl}/app/php/b2/addFileMetaData.php`, fileData, callback);
    }
}
