$(function () {
    $(".btn-edit-profile").click(function () {
        let username = $('.username').text(),
            email = $('.useremail').text(),
            profile = $('.userprofile').prop('src');

        $('#edit-prev-img').prop('src', profile);
        $('#edit-email').val(email)
        
        showPopup('popup-update-profile');
        $('#edit-username').val(username).focus();
    })
})