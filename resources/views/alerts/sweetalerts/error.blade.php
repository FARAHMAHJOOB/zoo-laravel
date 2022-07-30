@if(session('swal-error'))

<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            text: '{{ session("swal-error") }}' ,
            title:'عملیات انجام نشد'
        })
    })
</script>

@endif
