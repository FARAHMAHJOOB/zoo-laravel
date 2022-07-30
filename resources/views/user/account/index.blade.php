@extends('user.account.layouts.master')
@section('title')
    داشبورد
@endsection
@section('account-content')
    <div class="col-12 col-md-9 left-side-account-dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm bg-light mb-3 px-0 pt-0 card-header-rounded-top" id="accountInfoDiv">
                    <div class="card-header w-100 h-100 h3 py-3 card-header-rounded-top">اطلاعات حساب کاربری</div>
                    <div class="row card-body mt-1 d-flex tm-text-gray">
                        <h6 class="col-12 col-md-6 my-4"><i class="fa fa-user"></i> نام کاربری :
                            {{ Auth::user()->showAvatarName }}
                        </h6>
                        <div class="col-12 col-md-6 my-4 d-flex">
                            <i class="fa fa-user ml-1"></i>
                            <h6 class="mx-1"> نام :</h6>
                            <span class="d-flex align-items-center">
                                <h6>{{ Auth::user()->first_name ?? '--' }}</h6>
                                <i class="fas fa-edit mr-3 h5 editAccountBtn" aria-hidden="true" name_data="first_name"></i>
                            </span>
                        </div>

                        <div class="col-12 col-md-6 my-4 d-flex">
                            <i class="fa fa-user ml-1"></i>
                            <h6 class="mx-1"> نام خانوادگی :</h6>
                            <span class="d-flex align-items-center">
                                <h6>{{ Auth::user()->last_name ?? '--' }}</h6>
                                <i class="fas fa-edit mr-3 h5 editAccountBtn" aria-hidden="true" name_data="last_name"></i>
                            </span>
                        </div>

                        <div class="col-12 col-md-6 my-4 d-flex">
                            <i class="fa fa-phone ml-1"></i>
                            <h6 class="mx-1"> شماره موبایل :</h6>
                            <span class="d-flex align-items-center">
                                <h6>{{ Auth::user()->mobile ? convertEnglishToPersian(Auth::user()->mobile) : '--' }}</h6>
                                <i class="fas fa-edit mr-3 h5 editAccountBtn" aria-hidden="true" name_data="mobile"></i>
                            </span>

                        </div>


                        <div class="col-12 col-md-6 my-4 d-flex">
                            <i class="fa fa-envelope ml-1"></i>
                            <h6 class="mx-1"> ایمیل :</h6>
                            <span class="d-flex align-items-center">
                                <h6>{{ Auth::user()->email ?? '--' }}</h6>
                                <i class="fas fa-edit mr-3 h5 editAccountBtn" aria-hidden="true" name_data="email"></i>
                            </span>
                        </div>
                        <div class="col-12 col-md-6 my-4 d-flex">
                            <i class="fa fa-align-justify ml-1"></i>
                            <h6 class="mx-1"> کد ملی :</h6>
                            <span class="d-flex align-items-center">
                                <h6>{{ Auth::user()->national_code ? convertEnglishToPersian(Auth::user()->national_code) : '--' }}
                                </h6>
                                <i class="fas fa-edit mr-3 h5 editAccountBtn" aria-hidden="true"
                                    name_data="national_code"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm bg-light mb-3 px-0 pt-0 card-header-rounded-top" id="accountInfoDiv">
                    <div class="card-header w-100 h-100 h3 py-3 card-header-rounded-top">اعلانات</div>
                    <div class="row card-body mt-1 d-flex tm-text-gray">
                        <div class="col-12 col-md-6 my-4 d-flex">
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                <i class="fa fa-check text-danger mx-2" aria-hidden="true"></i> {{ $notification->data['message'] }}
                            @endforeach
                           {{ Auth::user()->unreadNotifications->markAsRead(); }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editAccountModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ویرایش اطلاعات حساب</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body my-4">
                    <form method="post" id="editAccountForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="editAccountInput" name="" value="">
                        </div>
                        <span id="showAttentionToUser" class="text-secondary"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary py-1 px-2 rounded" data-dismiss="modal">انصراف</button>
                    <button type="button" class="btn btn-primary py-1 px-3" id="submitEditAccountBtn">ثبت</button>
                </div>
            </div>
        </div>
    </div>
@endsection
