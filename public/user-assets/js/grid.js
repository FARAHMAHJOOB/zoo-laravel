
$(document).ready(function () {

    $('#navbar-toggler').click(function () {
        $('#navbarSupportedContent').fadeToggle();
    })

    $('#header-profile-toggle').click(function () {
        $('#header-profile').fadeToggle();
    })

    $('#profile-toggle').click(function () {
        $('#body-header').fadeToggle();
    })

})




function successToast(message) {
    var successToastTag = '<section class="toast" data-delay="5000">\n' +
        '<section class="toast-body py-3 d-flex bg-blue-theme text-white">\n' +
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
        '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
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


const swiper = new Swiper('.swiper', {
    // rewind:true,
    parallax: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction:false,
      },
    effect:'fade',
    speed:600,
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable : true,
      },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
      draggable: true,
    },

  });


