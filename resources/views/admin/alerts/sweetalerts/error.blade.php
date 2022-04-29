@if(session('swal-error'))

<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'error',
            text: 'عملیات ناموفق' , 
            title:'عملیات انجام نشد'
        })
    })
</script>

@endif