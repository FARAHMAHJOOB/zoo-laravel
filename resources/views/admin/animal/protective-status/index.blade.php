@extends('admin.layouts.master')

@section('title')
    وضعیت حفاظتی
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15"><a href="{{ route('admin.animal.index') }}"> حیوانات </a></li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"> وضعیت حفاظتی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        وضعیت حفاظتی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <div>
                        <a href="" class="btn btn-sm text-white blue-color btn-hover" data-toggle="modal"
                            data-target="#exampleModal" data-whatever="@mdo">وضعیت حفاظتی جدید </a>
                    </div>
                </section>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="light-blue">
                                <th class="py-2">#</th>
                                <th class="py-2"> عنوان</th>
                                <th class="py-2">توضیحات</th>
                                <th class="py-2">وضعیت </th>
                                <th class="text-left py-2 pl-4">تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($protectiveStatus as $status)
                                <tr>
                                    <td class="">{{ $loop->iteration }}</td>
                                    <th class="">{{ $status->title }}</th>
                                    <td class="" title="{{ $status->description }}">{!! Str::limit($status->description, 50) !!}
                                    </td>
                                    <td>
                                        <label class="pointer">
                                            <input class="pointer" id="{{ $status->id }}"
                                                onchange="changeStatus('{{ $status->id }}')"
                                                data-url="{{ route('admin.animal.protectiveStatus.status', $status->id) }}"
                                                type="checkbox" @if ($status->getRawOriginal('status') === 1) checked @endif>
                                        </label>
                                    </td>
                                    <td class="text-left d-flex ltr pt-2 pl-0">
                                        <form action="{{ route('admin.animal.protectiveStatus.destroy', $status->id) }}"
                                            method="POST" title="حذف">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i
                                                    class="fa fa-times-circle text-danger"></i></button>
                                        </form>
                                        <a href="{{ route('admin.animal.protectiveStatus.edit', $status->id) }}"
                                            class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i
                                                class="fa fa-edit blue"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </section>

    <!-- modal for new record -->
    <div class="modal fade rounded" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title blue" id="exampleModalLabel">وضعیت حفاظتی جدید</h5>
                </div>
                <div class="modal-body">
                    <section class="col-12 py-3 mb-3">
                        <form action="{{ route('admin.animal.protectiveStatus.store') }}" method="post"
                            id="addanimalProtectiveForm">
                            @csrf
                            <label for="title" class="blue">عنوان</label>
                            <div class="form-group mb-1">
                                <input type="text" class="form-control form-control-sm border-blue"
                                    placeholder="عنوان وضعیت ..." id="title" name="title" />
                            </div>
                            @error('title')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                            <br>
                            <label for="description" class="mt-3 blue">توضیحات</label>
                            <div class="form-group mb-2">
                                <textarea class="form-control form-control-sm border-blue" placeholder="توضیحات ..." id="description" name="description"
                                    rows="3"></textarea>
                            </div>
                            @error('description')
                                <span class="text-danger">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
                        </form>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">انصراف</button>
                    <button type="button" class="btn blue-color text-white btn-hover" id="addanimalProtectiveFormButton"
                        onclick="submitStoreForm()">ثبت</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function submitStoreForm() {
            $('#addanimalProtectiveForm').submit();

        }

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

    @include('alerts.sweetalerts.confirm', ['className' => 'delete', 'message' => 'وضعیت حفاظتی حذف شود؟'])
@endsection
