let showMenu;


$(function () {
    let fileId = null;

    showMenu = function (ev) {
        ev.stopPropagation();
        fileId = ev.target.closest('.file-wrapper').dataset.fileid;
        if (fileId) {
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

    function togglePopup(action) {
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
                totalSize = getTotalSize(fileId);
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
                $("#edit-filename").val(file.name).focus()[0];
                return;
            }
        }

        showErr('the file is deleted or is proccessing in background...');
    }

    function showPasskeyPopup(data) {
        if(data){
            if(!ISPASSKEYSET){
                showPopup('popup-set-passkey');
                return;
            }
        }
    }
})