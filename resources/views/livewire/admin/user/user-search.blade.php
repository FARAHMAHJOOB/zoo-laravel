<section class="row">
@include('livewire.loading')
<div wire:offline class="alert alert-danger mx-3 w-100 my-0 font-weight-bold pr-4 alert-dismissible fade show" role="alert">
    ارتباط اینترنت قطع است
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
</div>
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    کاربران
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.user.create') }}"
                        class="btn btn-sm text-white blue-color btn-hover">کاربر جدید</a>
                    <div class="width-13-rem width-md-16-rem">
                        <input type="text" wire:model="searchTerm"
                            class="form-control form-control-sm form-text border-blue"
                            placeholder="جستجوی کاربران بر اساس نام و ایمیل..." id="searchInput">
                        <ul class="searchBox list-group width-16-rem width-md-16-rem border" id="searchResult">
                            @if ($searchTerm !== '' && $users->count() < 1)
                                <li class="list-group-item p-1">کاربری با این مشخصات یافت نشد</li>
                            @else
                                <li class="list-group-item p-1" wire:loading>در حال جستجو...</li>
                            @endif
                        </ul>
                    </div>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover" id="userTable">
                        <thead>
                            <tr class="light-blue">
                                <th>#</th>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>شماره موبایل</th>
                                <th>کد ملی</th>
                                <th>وضعیت</th>
                                <th class="text-left"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        @if ($users && count($users) > 0)
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <th>{{ $user->fullName }} </th>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{ $user->mobile ?? '-' }} </td>
                                        <td>{{ $user->national_code ?? '-' }}</td>
                                        <td class=""><label class="pointer">
                                                <input class="pointer" type="checkbox" id="{{ $user->id }}"
                                                    onchange="changeStatus('{{ $user->id }}')"
                                                    data-url="{{ route('admin.user.status', $user->id) }}"
                                                    @if ($user->status === 1) checked @endif>
                                            </label>
                                        </td>
                                        <td class="text-left d-flex ltr pt-2 pl-0 border-top-">
                                            <form action="{{ route('admin.user.destroy', $user->id) }}"
                                                method="POST" title="حذف">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-lg py-0 px-2 btn-hover delete"><i
                                                        class="fa fa-times-circle text-danger"></i></button>
                                            </form>
                                            <a href="{{ route('admin.user.edit', $user->id) }}"
                                                class="btn btn-lg py-0 px-2 btn-hover" title="ویرایش"><i
                                                    class="fa fa-edit blue"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        @endif
                    </table>
                </section>

            </section>

        </section>
        {{ $users->links('livewire.livewire-paginatore') }}
    </section>
</section>
