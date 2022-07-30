$(document).ready(function () {

    function removeAllSidebarToggleClass() {
        $('#sidebar-toggle-hide').removeClass('d-md-inline');
        $('#sidebar-toggle-hide').removeClass('d-none');
        $('#sidebar-toggle-show').removeClass('d-inline');
        $('#sidebar-toggle-show').removeClass('d-md-none');
    }


    $('#sidebar-toggle-hide').click(function () {
        $('#sidebar').fadeOut(300);
        $('#main-body').animate({ width: "100%" }, 300);
        setTimeout(function () {
            removeAllSidebarToggleClass();
            $('#sidebar-toggle-hide').addClass('d-none');
            $('#sidebar-toggle-show').removeClass('d-none');
        }, 300)
    });



    $('#sidebar-toggle-show').click(function () {
        $('#sidebar').fadeIn(300);
        setTimeout(function () {
            removeAllSidebarToggleClass();
            $('#sidebar-toggle-hide').removeClass('d-none');
            $('#sidebar-toggle-show').addClass('d-none');
        }, 300);
    });

    $('#menu-toggle').click(function () {
        $('#body-header').toggle(300);
    });

    $('#search-toggle').click(function () {
        $('#search-toggle').removeClass('d-md-inline');
        $('#search-area').addClass('d-md-inline');
        $('#search-input').animate({ width: "12rem" }, 300);
    });

    $('#search-area-hide').click(function () {
        $('#search-input').animate({ width: "0" }, 300);
        setTimeout(function () {
            $('#search-toggle').addClass('d-md-inline');
            $('#search-area').removeClass('d-md-inline');
        }, 300);
    });

    $('#header-notification-toggle').click(function () {
        $('#header-notification').fadeToggle();
    });

    $('#header-comment-toggle').click(function () {
        $('#header-comment').fadeToggle();
    });

    $('#header-profile-toggle').click(function () {
        $('#header-profile').fadeToggle();
    });



    $('.sidebar-group-link').click(function () {

        $('.sidebar-group-link').removeClass('sidebar-group-link-active');
        $('.sidebar-group-link').children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-down');
        $('.sidebar-group-link').children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-left');
        $(this).addClass('sidebar-group-link-active');
        $(this).children('.sidebar-dropdown-toggle').children('.angle').removeClass('fa-angle-left');
        $(this).children('.sidebar-dropdown-toggle').children('.angle').addClass('fa-angle-down');
    });

});




$('#full-screen').click(function () {
    toggleFullScreen();
});

function toggleFullScreen() {
    if ((document.fullScreenElement && document.fullScreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }
        else if (document.documentElement.mozRequestFullscreen) {
            document.documentElement.mozRequestFullscreen();
        }
        else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
        $('#screen-compress').removeClass('d-none');
        $('#screen-expand').addClass('d-none');
    }
    else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        }
        else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        }
        else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
        $('#screen-compress').addClass('d-none');
        $('#screen-expand').removeClass('d-none');
    }
}

let notificationDropdown = document.getElementById('header-notification-toggle');
notificationDropdown.addEventListener('click', function () {
    let notifications = '';
    if (notifications > 0) {
        $.ajax({
            type: "POST",
            url: '/admin/notification/read-all',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {
            }
        })
    }
});

function successToast(message) {
    var successToastTag = '<section class="toast" data-delay="5000">\n' +
        '<section class="toast-body py-3 d-flex light-blue text-dark">\n' +
        '<strong class="ml-auto">' + message + '</strong>\n' +
        '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
        '<span aria-hidden="true">&times;</span>\n' +
        '</button>\n' +
        '</section>\n' +
        '</section>';

    $('.toast-wrapper').append(successToastTag);
    $('.toast').toast('show').delay(5000).queue(function () {
        $(this).remove();
    })
}
function errorToast(message) {
    var errorToastTag = '<section class="toast" data-delay="5000">\n' +
        '<section class="toast-body py-3 d-flex bg-danger text-dark">\n' +
        '<strong class="ml-auto">' + message + '</strong>\n' +
        '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
        '<span aria-hidden="true">&times;</span>\n' +
        '</button>\n' +
        '</section>\n' +
        '</section>';

    $('.toast-wrapper').append(errorToastTag);
    $('.toast').toast('show').delay(5500).queue(function () {
        $(this).remove();
    })
}

$(document).ready(function () {
    $('#searchInput').blur(function () {
        if (!$('#searchResult:hover').length != 0) {
            $('#searchResult').hide();
        }
    });
    $('#searchInput').click(function () {
        $('#searchResult').show();
    });
});

