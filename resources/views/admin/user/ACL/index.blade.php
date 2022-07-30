@extends('admin.layouts.master')

@section('title')
    نقش ها
@endsection


@section('content')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-15"> <a href="{{ route('admin.home') }}">خانه </a></li>
            <li class="breadcrumb-item font-size-15"> کاربران </li>
            <li class="breadcrumb-item font-size-15 active" aria-current="page"><a href="{{ route('admin.role.index') }}"> نقش
                    ها </a></li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h4>
                        نقش ها
                    </h4>
                    <section class="d-flex justify-content-between align-items-center my-4">
                        <a href="{{ route('admin.role.create') }}" class="btn btn-sm text-white blue-color btn-hover">نقش
                            جدید</a>
                    </section>
                    <section class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="light-blue">
                                    <th>#</th>
                                    <th>نام</th>
                                    <th>دسترسی ها</th>
                                    <th class=" text-left"></i> تنظیمات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $role->name }} </td>
                                        <td>
                                            @if (empty(
                                                $role->permissions()->get()->toArray()
                                            ))
                                                <i class="fa fa-times text-danger mr-1"></i> بدون دسترسی
                                            @else
                                                @foreach ($role->permissions as $permission)
                                                    <i class="fa fa-check text-primary mr-1"></i> {{ $permission->name }}
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-left d-flex ltr pt-2 pl-0">
                                            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST"
                                                title="حذف">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i
                                                        class="fa fa-times-circle text-danger"></i></button>
                                            </form>
                                            <a href="{{ route('admin.role.edit', $role->id) }}"
                                                class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش" id="editButton"><i
                                                    class="fa fa-edit blue"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>

                </section>
            </section>
        </section>
    @endsection

    @section('script')
        @include('alerts.sweetalerts.confirm', ['className' => 'delete', 'message' => 'نقش حذف شود؟'])
    @endsection
