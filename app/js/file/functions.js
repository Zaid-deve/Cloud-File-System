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



// to fetch files

function fetchFiles(options) {
    let data = { fileType: 'public' };

    if (options.fileType == 'private') {
        if (!options.passKey) {
            options?.error("Invalid passkey, please enter passkey");
            return;
        } else {
            data.passKey = options.passKey;
            data.fileType = 'private';
        }
    }

    $.post(`${baseurl}/app/php/b2/fetchFiles.php`, data, function (resp) {
        try {
            const r = JSON.parse(resp);
            if (r.Success) {
                options?.success(r.Files);
            } else {
                throw new Error(r.Err);
            }
        } catch (e) {
            if (typeof options.error == 'function') {
                options.error(e.message);
            }
        }
    }).fail(() => {
        if (typeof options.error == 'function') options.error("Something Went Wrong !");
    });
}

function searchFiles(files, qry) {
    if (files) {
        return __Files.filter(f => f.name.includes(qry) || f.type == qry);
    }
}

function getTotalSize(data) {
    let totalSize = 0,
        fileIds = data instanceof Set ? data : [data];

    fileIds.forEach(fileId => {
        let file = __Files.find(f => f.id === fileId);
        if (file && file.size) {
            totalSize += file.size;
        }
    });

    return totalSize;
}

function getFile(fileid) {
    return __Files.find(f => f.id == fileid);
}

function removeFile(data) {
    if (!Array.isArray(data)) {
        data = [data];
    }

    data.forEach(f => {
        let i = __Files.findIndex(fl => fl.id == f);
        if (i) {
            __Files.splice(i, 1);
        }

        __Checked.delete(f);
    })
}

function isSet(data) {
    return data instanceof Set;
}

/**
 * 
 * file menu events
 * 
 * hide file - 1
 * @param [set || fileId]
 */


function toggleHideFile(data, action) {
    if (data) {
        let postData,
            filesCount = 1;

        if (isSet(data)) {
            postData = Array.from(data);
        } else {
            postData = [data];
        }

        let formData = {
            data: JSON.stringify(postData),
            action: action
        };

        // Handle unhide action with passkey
        if (action === 'unhide') {
            if (!CURRENT_USER_PASSKEY) {
                hidePopup();
                showErr('Something Went Wrong !');
                return;
            }
            formData.passkey = CURRENT_USER_PASSKEY;
        }

        filesCount = postData.length;

        // Use $.post to send data
        $.post(`${baseurl}/app/php/file/toggleHideFile.php`, formData, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.Success) {
                    postData.forEach(file => {
                        removeFile(file);
                        removeWrapper(file)
                    });
                    showMsg(`${filesCount} file(s) ${action == 'hide' ? 'hidden' : 'un hidden'} successfully`, 'success');
                } else {
                    showErr(r.Err || 'Something Went Wrong !');
                }
            } catch (e) {
                showErr('Something Went Wrong');
            }
        }).fail(function () {
            showErr('Something Went Wrong with the request!');
        });
    }
}


function editFile(filename, perms, callback) {
    if (filename && perms) {
        $.post(`${baseurl}/app/php/file/editFile.php`, { filename, ...perms }, function (resp) {
            const r = JSON.parse(resp);
            callback(r);
        })
    }
}

function updateFile(data, callback) {
    if (data && data.filename) {
        $.post(`${baseurl}/app/php/file/editFile.php`, data, (resp) => {
            const r = JSON.parse(resp);
            if (typeof callback == "function") callback(r);
        }).fail((r, rc) => typeof callback === "function" ? callback({ Err: rc }) : '');
    }
}

function deleteFile(data, callback) {
    if (data) {
        if (Array.isArray(data)) {
            data = JSON.stringify(data);
        }

        $.post(`${baseurl}/app/php/file/deleteFile.php`, { data }, function (resp) {
            if (typeof callback === 'function') callback(JSON.parse(resp) ?? {});
        }).fail(callback);
    }
}

async function getSharingLink() {
    let resp;

    try {
        await $.post(`${baseurl}/app/php/file/getSharingLink.php`, function (r) {
            resp = JSON.parse(r);
        }).fail(() => { throw new Error() })
    } catch (e) {
        return false;
    }

    return resp;
}