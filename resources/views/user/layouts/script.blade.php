<script src="{{ asset('general-assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="{{ asset('general-assets/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('general-assets/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('general-assets/ckeditor/ckeditor.js') }}"></script>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="{{ asset('user-assets/js/grid.js') }}"></script>
<script src="{{ asset('user-assets/js/plugins.js') }}"></script>
<script>
    $(window).on("load", function() {
        $('body').addClass('loaded');
    });
</script>
@livewireScripts
