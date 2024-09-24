$(function () {
    $(".popup-container").click(function (e) {
        let t = $(e.target).closest('.popup');
        if (!t.length) {
            hidePopup();
        }
    })

    $('#profileimg').change(e => {
        const file = e.target.files[0]
        if (file) {
            if (!isImg(file)) {
                showErr('Profile image should be an valid image');
                return;
            }

            if (file.size > (1024 * 1024 * 2)) {
                showErr('Profile image should be of maximum 2 mb');
                return;
            }

            const blob = URL.createObjectURL(file);
            $('#edit-prev-img').prop('src', blob);
        }
    })

    $(".btn-update-profile").click(function () {
        $(".popup-update-profile").addClass('working');
        $(this).prop('disabled', true);

        try {
            let formData = new FormData();
            formData.append('name', $("#edit-username").val());
            formData.append('profile', $("#profileimg")[0].files[0]);

            $.ajax({
                url: '/cfs/app/php/editProfile.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (resp) {
                    const r = JSON.parse(resp);
                    if (r.Success) {
                        $('.userprofile').prop('src', URL.createObjectURL(formData.get('profile')));
                        $('.username').text(formData.get('name'));
                        hidePopup();
                    } else {
                        showErr(r.Err);
                    }
                },
                error: function (err) {
                    showErr('An error occurred during the request.');
                }
            });
        } catch (e) {
            showErr(e.message);
        } finally {
            $(".popup-update-profile").removeClass('working');
            $(this).prop('disabled', false);
        }
    });



    // menu listeners
    $("#passkey-inp").on('input', function () {
        $("#btn-setpasskey").prop('disabled', !($(this).val().length >= 6 && $(this).val().length <= 24));
    })

    $("#btn-setpasskey").click(async function () {
        $("#passkey-inp").prop('disabled', true);
        $.post(`${baseurl}/app/user/setpasskey.php`, { passkey: $("#passkey-inp").val().trim() }, function (r) {
            const resp = JSON.parse(r);
            if (resp.Success) {
                location.reload();
                return;
            }

            $("#passkey-inp").next().text(resp.Err || "Failed to set passkey");
            $("#passkey-inp").prop('disabled', false);
        })
    })

    /**
     * Edit File 
     */

    function isValidFilename(name) {
        return name && !name.match(/[\/\\:*?"<>|]/)
    }

    let filename = $("#edit-filename"),
        filenameErr = filename.next(),
        viewPerm = $('#view-permission'),
        editPerm = $('#edit-permission'),
        editBtn = $('#btn-update-file')

    $('#view-permission, #edit-permission').change(() => {
        if (isValidFilename(filename.val())) {
            editBtn.prop('disabled', false);
        }
    })

    filename.change(() => {
        editBtn.prop('disabled', !isValidFilename(filename.val()));
    })

    editBtn.click(() => {
        if (!isValidFilename(filename.val())) {
            filenameErr.text("invalid file name");
        } else {
            // disabled inputs
            filenameErr.text('');
            editBtn.addClass('working')
            $('.popup-eidt').addClass('working');
            [filename, viewPerm, editPerm, editBtn].forEach((i, e) => e.disabled = true);

            // perms
            let [r, w] = [viewPerm[0].checked, editPerm[0].checked];

            updateFile({ filename: filename.val(), r, w, fileId: CURRENT_TARGET_ID }, function (resp) {
                editBtn.removeClass('working')
                $('.popup-eidt').removeClass('working');
                [filename, viewPerm, editPerm, editBtn].forEach((i, e) => e.disabled = false);

                if (resp.Success) {
                    hidePopup();
                    let wrapper = getWrapper(CURRENT_TARGET_ID);
                    if (wrapper.length) {
                        wrapper.find('.file-title').text(filename.val());

                        let file = getFile(CURRENT_TARGET_ID);
                        if (file) {
                            file.name = filename.val();
                            file.perms.read = r
                            file.perms.write = w
                        }
                    }
                    return;
                }

                showErr(resp.Err || 'Failed to edit file !');
            });
        }
    })



    /**
     * delete file
     */

    let deleteBtn = $('#btn-confirm-delete');
    deleteBtn.click(() => {
        let t;
        if (__Checked.size) {
            t = Array.from(__Checked)
        } else {
            t = [CURRENT_TARGET_ID]
        }

        if (t) {
            $('.popup-delete').addClass('working')
            deleteBtn.addClass('working').prop('disabled', true);

            deleteFile(t, function (resp) {
                $('.popup-delete').removeClass('working')
                deleteBtn.removeClass('working').prop('disabled', false);

                if (resp.Success) {
                    hidePopup();
                    removeFile(t);
                    removeWrapper(t);
                    return;
                }

                showErr(resp.Err || "Failed to delete file");
            })
        }
    })
});


function requestPasskey() {
    return new Promise((res, rej) => {
        showPopup('popup-enter-passkey')
        $('.popup-enter-passkey').addClass('working');
        $('#enter-passkey-inp').focus();
        $('.btn-confirm-passkey').click(function () {
            let k = $('#enter-passkey-inp').val();
            if (k && (k.length >= 6 && k.length <= 24)) {
                $('.popup-enter-passkey').removeClass('working');
                hidePopup()
                $('#enter-passkey-inp').next().text('');
                res(k);
            } else {
                $('#enter-passkey-inp').next().text('Invalid passkey');
            }
        })
    })
}