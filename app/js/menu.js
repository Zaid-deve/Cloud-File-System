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
    
})