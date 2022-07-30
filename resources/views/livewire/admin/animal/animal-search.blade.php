<section class="row">
    @include('livewire.loading')
    <div wire:offline class="alert alert-danger mx-3 w-100 my-0 font-weight-bold pr-4 alert-dismissible fade show"
        role="alert">
        ارتباط اینترنت قطع است
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>
                    حیوانات
                </h4>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="{{ route('admin.animal.create') }}"
                        class="btn btn-sm text-white blue-color btn-hover">حیوان
                        جدید</a>
                    <div class="width-13-rem width-md-16-rem">
                        <input type="text" wire:model="searchTerm"
                            class="form-control form-control-sm form-text border-blue" placeholder="جستجو در حیوانات..."
                            id="searchInput">
                        <ul class="searchBox list-group width-16-rem width-md-16-rem border" id="searchResult">
                            @if ($searchTerm !== '' && $animals->count() < 1)
                                <li class="list-group-item p-1">حیوانی با این مشخصات یافت نشد</li>
                            @else
                                <li class="list-group-item p-1" wire:loading>در حال جستجو...</li>
                            @endif
                        </ul>
                    </div>
                </section>

                <div class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                            <tr class="light-blue">
                                <th class="py-2">#</th>
                                <th class="py-2"> نام</th>
                                <th class="py-2">خلاصه</th>
                                <th class="py-2">دسته</th>
                                <th class="py-2">تاریخ انتشار</th>
                                <th class="py-2">عکس</th>
                                <th class="py-2">وضعیت </th>
                                <th class="text-left py-2 pl-4">تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animals as $animal)
                                <tr>
                                    <td class="">{{ $loop->iteration }}</td>
                                    <th class="">{{ $animal->name }}</th>
                                    <td class="" title="{{ $animal->summary }}">
                                        {{ Str::limit($animal->summary, 20) }}</td>
                                    <td class="">{{ $animal->category->name }}</td>
                                    <td class="">{{ jalaliDate($animal->published_at) }}</td>
                                    @if ($animal->image)
                                        <td class="py-1"><a
                                                href="{{ url($animal->image['indexArray'][$animal->image['currentImage']]) }}"
                                                target="_blank" title="مشاهده "><img
                                                    src="{{ asset($animal->image['indexArray'][$animal->image['currentImage']]) }}"
                                                    alt="" width="50px" height="40px"></a></td>
                                    @else
                                        <td class="">----</td>
                                    @endif
                                    <td>
                                        <label class="pointer">
                                            <input class="pointer" id="{{ $animal->id }}"
                                                onchange="changeStatus('{{ $animal->id }}')"
                                                data-url="{{ route('admin.animal.status', $animal->id) }}"
                                                type="checkbox" @if ($animal->getRawOriginal('status') === 1) checked @endif>
                                        </label>
                                    </td>
                                    <td class="text-left d-flex ltr pt-1 pl-0">
                                        <a href="{{ route('admin.animal.show', $animal->id) }}"
                                            class="btn btn-lg py-0 btn-hover" title="جزییات"><i
                                                class="fa fa-info-circle blue"></i></a>
                                        <div class="dropdown ml-0 ">
                                            <a href="#" title="عملیات"
                                                class="btn btn-lg py-0 px-1 btn-hover text-success dorpdown-toggle"
                                                role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fas fa-tools"></i>
                                            </a>
                                            <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuLink">
                                                <a href="{{ route('admin.animal.gallery.index', $animal->id) }}"
                                                    class="dropdown-item text-right text-primary border-bottom"><i
                                                        class="fa fa-picture-o"></i> گالری</a>
                                                <a href="{{ route('admin.animal.edit', $animal->id) }}"
                                                    class="dropdown-item text-right border-bottom"><i
                                                        class="fa fa-edit blue"></i>
                                                    ویرایش</a>
                                                <form action="{{ route('admin.animal.destroy', $animal->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        class="dropdown-item text-right text-danger border-bottom delete"><i
                                                            class="fa fa-window-close"></i> حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
        {{ $animals->links('livewire.livewire-paginatore') }}
    </section>
</section>
