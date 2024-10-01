$(function () {
    $('.page-loader').fadeOut(500, function () {
        $('.page-loader').addClass('d-none')
    })

    // set header height
    let header = $('.page-header');
    $(window).on('resize load', function () {
        $(':root').css('--header--height', header.outerHeight() + 'px');
    });
})