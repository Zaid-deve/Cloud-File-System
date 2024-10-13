let showMenu,
    showSharePopup;


$(function () {
    showMenu = function (ev) {
        ev.stopPropagation();
        CURRENT_TARGET_ID = ev.target.closest('.file-wrapper').dataset.fileid;
        if (CURRENT_TARGET_ID) {
            $('.menu-list').addClass('show')
            const coords = getCoords(ev);
            displayMenu(coords);
        }
    }

    function getCoords(ev) {
        let { clientX, clientY } = ev,
            menu = $(".menu-list"),
            mwidth = menu.outerWidth(),
            mheight = menu.outerHeight();

        if ((clientX + mwidth) > innerWidth) {
            clientX = (innerWidth - mwidth) - 10;
        }

        if (clientY + mheight > innerHeight) {
            clientY = (innerHeight - mheight) - 10;
        }

        return { top: `${clientY}px`, left: `${clientX}px` }
    }


    function displayMenu(coords) {
        if (coords) {
            if (currPage == 'share.php') {
                let file = getFile(CURRENT_TARGET_ID);
                if (file) {
                    if (!file.perms.write) {
                        $(".menu-list .list-group-item[data-action='edit']").hide();
                    } else {
                        $(".menu-list .list-group-item[data-action='edit']").show();
                    }
                }
            }

            $('.menu-list').css(coords)
        }
    }

    function hideMenu() {
        $('.menu-list').removeClass('show')
    }

    $(window).click(function (ev) {
        if (!ev.target.closest('.menu-list')) {
            hideMenu();
        }
    })

    // menu events
    $(".menu-list .list-group-item").click(function () {
        let action = $(this).data('action');
        if (action) {
            hideMenu();
            togglePopup(action);
        }
    })

    function togglePopup(action, fileId = CURRENT_TARGET_ID) {
        let t = __Checked.size > 0 ? __Checked : fileId;

        if (action === 'delete') {
            showDeletePopup(t);
        } else if (action === 'edit') {
            showEditFile(fileId);
        } else if (action === 'hide' || action === 'unhide') {
            showPasskeyPopup(t, action);
        } else if (action === 'share') {
            showSharePopup(t);
        } else if (action === 'download') {
            if (typeof t == 'string') {
                t = [t];
            } else {
                t = Array.from(t);
            }
            showDownloadPopup(getFilesArray(t));
        }

        toggleCheck(Array.from(t), 'uncheck');
    }



    // popup listeners 
    function showDeletePopup(data) {
        if (data) {
            showPopup('popup-delete');
            let totalFiles = 1,
                totalSize = 0;

            data = typeof data != "string" ? Array.from(data) : [data];
            totalFiles = data.length;
            data.forEach(f => {
                totalSize += f.size;
            })

            if (totalSize) {
                totalSize = formatBytes(totalSize);
            }

            $(".delete-ins").html(`<p>${totalFiles} files will be deleted</p><p>${totalSize} will be free from space</p><p>this action cannot be undone.<br>do it in your own risk</p>`)
            return;
        }

        showErr('the file is already deleted or is deleting in background...');
    }

    function showEditFile(fileId) {
        if (fileId) {
            let file = __Files.find(f => f.id == fileId);
            if (file) {
                showPopup('popup-edit');
                $("#edit-filename").val(file.name).focus()
                let perms = file.perms;
                $("#view-permission").prop('checked', perms.read);
                $("#edit-permission").prop('checked', perms.write);

                return;
            }
        }

        showErr('the file is deleted or is proccessing in background...');
    }

    function showPasskeyPopup(data, action) {
        if (data) {
            if (!ISPASSKEYSET) {
                showPopup('popup-set-passkey');
                return;
            } else {
                toggleHideFile(data, action);
            }
        }
    }


    const copyLinkBtn = $('#btn-copy-link');

    showSharePopup = async function (data, copy = false) {
        if (data) {
            showPopup('popup-share');
            copyLinkBtn.prop('disabled', true).addClass("working");

            let shareLink;

            if (data == 'folder') {
                shareLink = await getSharingLink();
                $('#share-link').next("Be Sure You Are Sharing Your All Files, anyone can access your all public files");

                if (shareLink.Success && shareLink.ShareUri) {
                    shareLink = shareLink.ShareUri;
                } else {
                    $('#share-link').next(r.Err);
                }
            } else {
                shareLink = `${baseurl}/app/view/share.php?data=${data}&shareType=file`;
            }


            $('#share-link').val(shareLink);
            copyLinkBtn.prop('disabled', false).removeClass("working");

            $('#btn-share-facebook').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareLink)}`);
            $('#btn-share-twitter').attr('href', `https://twitter.com/intent/tweet?url=${encodeURIComponent(shareLink)}`);
            $('#btn-share-whatsapp').attr('href', `https://api.whatsapp.com/send?text=${encodeURIComponent(shareLink)}`);
            $('#btn-share-telegram').attr('href', `https://t.me/share/url?url=${encodeURIComponent(shareLink)}&text=Check this out!`);

            if (copy) {
                copyLinkBtn.click();
            }
        }
    }

    // copy link
    $('#btn-copy-link').click(function () {
        navigator.clipboard.writeText($('#share-link').val()).then(() => {
            $(this).find('i')[0].className = "fa-solid fa-check prime-color";
            showMsg("Link Copied To Clipboard", "success")
            hidePopup();
        }).catch(e => {
            showMsg(e);
            $(this).find('i')[0].className = "fa-solid fa-triangle-exclamation prime-color";
        });
    })

    $('#btn-share-folder').click(async function () {
        showSharePopup('folder');
    })

})