$(function () {
    let isRedirecting;

    $(".auth-red-btn").click(function (e) {
        if (isRedirecting) {
            e.preventDefault();
        } else {
            isRedirecting = true;
            $(".auth-red-btn").hide();
            $(this).show().addClass('working')
        }
    })
})