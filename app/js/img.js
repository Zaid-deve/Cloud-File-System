$(function () {
    $('body img.is-profile').each((f, i) => {
        $(i).on('error', function(){
            $(this).prop('src', `${baseurl}/app/images/default.png`)
        })
    })
})