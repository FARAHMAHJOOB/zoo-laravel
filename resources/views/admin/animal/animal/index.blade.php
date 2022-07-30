@extends('admin.layouts.master')

@section('title')
    حیوانات
@endsection


@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"><a
                    href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
        </ol>
    </nav>
    @livewire('admin.animal.animal-search')
@endsection

@section('script')
    <script type="text/javascript">
        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast('رکورد فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast('رکورد غیرفعال شد')
                        }
                    } else {
                        element.prop('checked', elementValue);
                        errorToast('در تغییر وضعیت مشکلی به جود آمد')
                    }
                },
                error: function() {
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });
        }
    </script>
    @include('alerts.sweetalerts.confirm', [
        'className' => 'delete',
        'message' => 'رکورد حذف شود؟',
    ])
@endsection
