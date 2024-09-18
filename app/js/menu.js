let showMenu;


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
            return;
        }

        if (action === 'edit') {
            showEditFile(fileId);
            return;
        }

        if (action === 'hide') {
            showPasskeyPopup(t);
            return;
        }

        if (action === 'share') {
            showSharePopup(t);
        }
    }


    // popup listeners 
    function showDeletePopup(data) {
        if (data) {
            showPopup('popup-delete');
            let totalFiles = 1,
                totalSize = 0;

            if (data instanceof Set) {
                if (data.size) {
                    totalSize = getTotalSize(data);
                    totalFiles = data.size;
                }
            } else {
                totalSize = getTotalSize(data);
            }

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
                return;
            }
        }

        showErr('the file is deleted or is proccessing in background...');
    }

    function showPasskeyPopup(data) {
        if (data) {
            if (!ISPASSKEYSET) {
                showPopup('popup-set-passkey');
                return;
            } else {
                hideFile(data);
            }
        }
    }


    const copyLinkBtn = $('#btn-copy-link');

    async function showSharePopup(data, copy = false) {
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