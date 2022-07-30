@if(session('swal-success'))
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'success',
            text: '{{ session("swal-success") }}' ,
            title:'عملیات موفق'
        })
    })
</script>
@endif
