@extends('user.layouts.master')

@section('content')
    <div class="row justify-content-between mb-5">
        @include('user.account.layouts.account-sidebar')
        @yield('account-content')
    </div>
@endsection
@section('script')
    <script>
        jQuery.ajaxSetup({
            beforeSend: function() {
                $('#parentLoader').show();
            },
            complete: function() {
                $('#parentLoader').hide();
            },
            success: function() {}
        });

        $('.editAccountBtn').on('click', function() {
            $('#editAccountInput').val($(this).prev().text());

            $('#editAccountInput').attr('name', $(this).attr("name_data"));
            $('#editAccountModal').modal('toggle');
        });
        $('#submitEditAccountBtn').on('click', function() {
            $('#editAccountForm').submit();
        });

        $(document).on('submit', '#editAccountForm', function(e) {
            e.preventDefault();
            var formData = new FormData($("#editAccountForm")[0]);
            $('#editAccountModal').modal('hide');
            $.ajax({
                url: "{{ route('user.account.edit-account-info') }}",
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    if (response.status) {
                        sessionStorage.setItem("toast-success", 'اطلاعات حساب شما ویرایش گردید');
                        location.reload(true);
                    } else {
                        errorToast('در ویرایش تصویر مشکلی به جود آمد')
                    }
                },
                error: function(result) {
                    errorToast('ارتباط برقرار نشد');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#profile_photo_path').on('change', function() {
                $('#frmEditProfilePhoto').submit();
            });
            $(document).on('submit', '#frmEditProfilePhoto', function(e) {
                e.preventDefault();
                var imageData = new FormData($("#frmEditProfilePhoto")[0]);
                $.ajax({
                    url: "{{ route('user.account.edit-profile-image') }}",
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: imageData,
                    success: function(response) {
                        if (response.status) {
                            successToast('تصویر پروفایل شما تغییر یافت');
                            $('.userImage').attr('src', response.userImg);
                        } else {
                            errorToast('در ویرایش تصویر مشکلی به جود آمد')
                        }
                    },
                    error: function(result) {
                        errorToast('ارتباط برقرار نشد');
                    }
                });
            });
        });
    </script>

    <script>
        $(function() {
            if (sessionStorage.getItem('toast-success')) {
                successToast('اطلاعات حساب شما ویرایش گردید');
                sessionStorage.removeItem('toast-success');
            }
        });
    </script>
@endsection
