$(function () {
    $('body img.is-profile').each((f, i) => {
        $(i).prop('src', `${baseurl}/app/images/default.png`)
    })
})