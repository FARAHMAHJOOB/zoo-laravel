<!-- @if(session('toast-success')) -->
@isset($success)

    <section class="toast" data-delay="5000">

        <section class="toast-body py-3 d-flex light-blue text-dark">
            <strong class="ml-auto">{{ session('toast-success') }}</strong>
            <button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </section>
    </section>

    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        })
    </script>

@endisset

<!-- @endif -->
