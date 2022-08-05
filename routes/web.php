<?php

use App\Http\Middleware\CheckStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\HomeFAQController;
use App\Http\Controllers\Admin\Faq\FaqController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\User\HomeAnimalController;
use App\Http\Controllers\User\HomeCategoryController;
use App\Http\Controllers\Admin\User\ManagerController;
use App\Http\Controllers\Admin\Animal\AnimalController;
use App\Http\Controllers\Admin\ACL\ManagerRoleController;
use App\Http\Controllers\Admin\Animal\AnimalMetaController;
use App\Http\Controllers\Auth\User\LoginRegisterConteroller;
use App\Http\Controllers\User\Account\UserAccountController;
use App\Http\Controllers\Admin\Content\ContentMenuController;
use App\Http\Controllers\Admin\Content\ContentPageController;
use App\Http\Controllers\Admin\Animal\AnimalGalleryController;
use App\Http\Controllers\Admin\Comment\AdminCommentController;
use App\Http\Controllers\Admin\Setting\AdminSettingController;
use App\Http\Controllers\Admin\Animal\AnimalCategoryController;
use App\Http\Controllers\Admin\Content\ContentSliderController;
use App\Http\Controllers\Admin\Dashboard\AdminDashboardController;
use App\Http\Controllers\Admin\Animal\AnimalProtectiveStatusController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::fallback(function () {
    return view('errors.404');
});

Auth::routes(['register' => false]);

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('login-register-form', [LoginRegisterConteroller::class, 'LoginRegisterForm'])->name('auth.user.login-register-form');
        Route::middleware('throttle:user-login-register-limiter')->post('login-register', [LoginRegisterConteroller::class, 'LoginRegister'])->name('auth.user.login-register');

        Route::get('login-register-confirm-form/{token}', [LoginRegisterConteroller::class, 'LoginRegisterConfirmForm'])->name('auth.user.login-register-confirm-form');
        Route::middleware('throttle:user-login-register-confirm-limiter')->post('login-register-confirm/{token}', [LoginRegisterConteroller::class, 'LoginRegisterConfirm'])->name('auth.user.login-register-confirm');
        Route::middleware('throttle:user-login-register-resend-otp-limiter')->get('login-register-resend-otp/{token}', [LoginRegisterConteroller::class, 'LoginRegisterResendOtp'])->name('auth.user.login-register-resend-otp');
        Route::get('logout', [LoginRegisterConteroller::class, 'Logout'])->name('auth.user.logout')->withoutMiddleware('guest');
    });
});

// home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/animal/{animal}/{slug}', [HomeAnimalController::class, 'index'])->name('home.animal')->middleware(CheckStatus::class);
Route::get('/categories', [HomeCategoryController::class, 'index'])->name('home.categories');
Route::get('/category/{category}/animals', [HomeCategoryController::class, 'show'])->name('home.category-animals');
Route::get('/faqs', [HomeFAQController::class, 'index'])->name('home.faqs');

// user account
Route::middleware('auth')->prefix('user')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('dashboard', [UserAccountController::class, 'index'])->name('user.account.dashboard');
        Route::post('edit-profile-image', [UserAccountController::class, 'EditProfileImage'])->name('user.account.edit-profile-image');
        Route::post('edit-account-info', [UserAccountController::class, 'EditAccountInfo'])->name('user.account.edit-account-info');
    });
});


Route::middleware(['auth' , 'IsAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');
    //admin/animals
    Route::middleware('can:read-animal')->prefix('animal')->group(function () {
        Route::get('/', [AnimalController::class, 'index'])->name('admin.animal.index');
        Route::get('show/{animal}', [AnimalController::class, 'show'])->name('admin.animal.show');
        Route::get('/create', [AnimalController::class, 'create'])->name('admin.animal.create')->middleware('can:create-animal');
        Route::post('/store', [AnimalController::class, 'store'])->name('admin.animal.store')->middleware('can:create-animal');
        Route::get('/edit/{animal}', [AnimalController::class, 'edit'])->name('admin.animal.edit')->middleware('can:edit-animal');
        Route::put('/update/{animal}', [AnimalController::class, 'update'])->name('admin.animal.update')->middleware('can:edit-animal');
        Route::delete('/destroy/{animal}', [AnimalController::class, 'destroy'])->name('admin.animal.destroy')->middleware('can:delete-animal');
        Route::get('/status/{animal}', [AnimalController::class, 'status'])->name('admin.animal.status')->middleware('can:edit-animal');
        Route::get('/search', [AnimalController::class, 'search'])->name('admin.animal.search');

        //animal/attribute
        Route::prefix('meta')->group(function () {
            Route::post('update/{meta}', [AnimalMetaController::class, 'update'])->name('admin.animal.meta.update');
            Route::delete('destroy/{meta}', [AnimalMetaController::class, 'destroy'])->name('admin.animal.meta.destroy');
            Route::post('{animal}/store', [AnimalMetaController::class, 'store'])->name('admin.animal.meta.store');
        });
        //animal/image
        Route::prefix('gallery')->group(function () {
            Route::get('/', [AnimalGalleryController::class, 'allGallery'])->name('admin.animal.gallery.allGallery');
            Route::get('/{animal}', [AnimalGalleryController::class, 'index'])->name('admin.animal.gallery.index');
            Route::delete('destroy/{image}', [AnimalGalleryController::class, 'destroy'])->name('admin.animal.image.destroy');
            Route::delete('destroyGallery/{animal}', [AnimalGalleryController::class, 'destroyGallery'])->name('admin.animal.gallery.destroy');
            Route::get('status/{image}', [AnimalGalleryController::class, 'status'])->name('admin.animal.image.status');
            Route::post('{animal}/store', [AnimalGalleryController::class, 'store'])->name('admin.animal.image.store');
        });

        //animal/category
        Route::prefix('category')->group(function () {
            Route::get('/', [AnimalCategoryController::class, 'index'])->name('admin.animal.category.index');
            Route::get('/show/{category}', [AnimalCategoryController::class, 'show'])->name('admin.animal.category.show');
            Route::get('/create', [AnimalCategoryController::class, 'create'])->name('admin.animal.category.create');
            Route::post('/store', [AnimalCategoryController::class, 'store'])->name('admin.animal.category.store');
            Route::get('/edit/{category}', [AnimalCategoryController::class, 'edit'])->name('admin.animal.category.edit');
            Route::put('/update/{category}', [AnimalCategoryController::class, 'update'])->name('admin.animal.category.update');
            Route::delete('/destroy/{category}', [AnimalCategoryController::class, 'destroy'])->name('admin.animal.category.destroy');
            Route::get('/status/{category}', [AnimalCategoryController::class, 'status'])->name('admin.animal.category.status');
        });

        //animal/protective-status
        Route::prefix('protective-status')->group(function () {
            Route::get('/', [AnimalProtectiveStatusController::class, 'index'])->name('admin.animal.protectiveStatus.index');
            Route::post('/store', [AnimalProtectiveStatusController::class, 'store'])->name('admin.animal.protectiveStatus.store');
            Route::get('/edit/{status}', [AnimalProtectiveStatusController::class, 'edit'])->name('admin.animal.protectiveStatus.edit');
            Route::put('/update/{status}', [AnimalProtectiveStatusController::class, 'update'])->name('admin.animal.protectiveStatus.update');
            Route::delete('/destroy/{status}', [AnimalProtectiveStatusController::class, 'destroy'])->name('admin.animal.protectiveStatus.destroy');
            Route::get('/status/{status}', [AnimalProtectiveStatusController::class, 'status'])->name('admin.animal.protectiveStatus.status');
        });
    });


    //admin/content
    Route::prefix('content')->group(function () {
        //content/menu
        Route::prefix('menu')->group(function () {
            Route::get('/', [ContentMenuController::class, 'index'])->name('admin.content.menu.index');
            Route::get('/create', [ContentMenuController::class, 'create'])->name('admin.content.menu.create');
            Route::post('/store', [ContentMenuController::class, 'store'])->name('admin.content.menu.store');
            Route::get('/edit/{menu}', [ContentMenuController::class, 'edit'])->name('admin.content.menu.edit');
            Route::put('/update/{menu}', [ContentMenuController::class, 'update'])->name('admin.content.menu.update');
            Route::delete('/destroy/{menu}', [ContentMenuController::class, 'destroy'])->name('admin.content.menu.destroy');
            Route::get('/status/{menu}', [ContentMenuController::class, 'status'])->name('admin.content.menu.status');
        });

        //content/slider
        Route::prefix('slider')->group(function () {
            Route::get('/', [ContentSliderController::class, 'index'])->name('admin.content.slider.index');
            Route::get('/create', [ContentSliderController::class, 'create'])->name('admin.content.slider.create');
            Route::post('/store', [ContentSliderController::class, 'store'])->name('admin.content.slider.store');
            Route::get('/edit/{slider}', [ContentSliderController::class, 'edit'])->name('admin.content.slider.edit');
            Route::put('/update/{slider}', [ContentSliderController::class, 'update'])->name('admin.content.slider.update');
            Route::delete('/destroy/{slider}', [ContentSliderController::class, 'destroy'])->name('admin.content.slider.destroy');
            Route::get('/status/{slider}', [ContentSliderController::class, 'status'])->name('admin.content.slider.status');
        });

        //content/page
        Route::prefix('page')->group(function () {
            Route::get('/', [ContentPageController::class, 'index'])->name('admin.content.page.index');
            Route::get('/create', [ContentPageController::class, 'create'])->name('admin.content.page.create');
            Route::post('/store', [ContentPageController::class, 'store'])->name('admin.content.page.store');
            Route::get('/edit/{page}', [ContentPageController::class, 'edit'])->name('admin.content.page.edit');
            Route::put('/update/{page}', [ContentPageController::class, 'update'])->name('admin.content.page.update');
            Route::delete('/destroy/{page}', [ContentPageController::class, 'destroy'])->name('admin.content.page.destroy');
            Route::get('/status/{page}', [ContentPageController::class, 'status'])->name('admin.content.page.status');
        });
    });
    //admin/users
    Route::middleware(['role:superAdmin'])->prefix('user')->group(function () {
        //managers
        Route::prefix('manager')->group(function () {
            Route::get('/', [ManagerController::class, 'index'])->name('admin.manager.index');
            Route::get('/create', [ManagerController::class, 'create'])->name('admin.manager.create');
            Route::post('/store', [ManagerController::class, 'store'])->name('admin.manager.store');
            Route::get('/edit/{admin}', [ManagerController::class, 'edit'])->name('admin.manager.edit');
            Route::put('/update/{admin}', [ManagerController::class, 'update'])->name('admin.manager.update');
            Route::delete('/destroy/{admin}', [ManagerController::class, 'destroy'])->name('admin.manager.destroy');
            Route::get('/status/{admin}', [ManagerController::class, 'status'])->name('admin.manager.status');

            Route::get('/{admin}/role', [ManagerRoleController::class, 'editRole'])->name('admin.manager.editRole');
            Route::post('/{admin}/role/update', [ManagerRoleController::class, 'updateRole'])->name('admin.manager.updateRole');
        });

        //users
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/update/{user}', [UserController::class, 'update'])->name('admin.user.update');
            Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            Route::get('/status/{user}', [UserController::class, 'status'])->name('admin.user.status');
        });

        //ACL / role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
            Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.role.edit');
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.role.update');
            Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.role.destroy');
            Route::get('/status/{role}', [RoleController::class, 'status'])->name('admin.role.status');

        });
    });

    //admin/comment
    Route::middleware('can:read-comment')->prefix('comment')->group(function () {
        Route::get('/', [AdminCommentController::class, 'index'])->name('admin.comment.index');
        Route::get('/unseen-comment', [AdminCommentController::class, 'unseenComment'])->name('admin.comment.unseenComment');
        Route::get('/show/{comment}', [AdminCommentController::class, 'show'])->name('admin.comment.show');
        Route::post('/answer/{comment}', [AdminCommentController::class, 'answer'])->name('admin.comment.answer');
        Route::put('/update/{comment}', [AdminCommentController::class, 'update'])->name('admin.comment.update');
        Route::delete('/destroy/{comment}', [AdminCommentController::class, 'destroy'])->name('admin.comment.destroy');
        Route::get('/status/{comment}', [AdminCommentController::class, 'status'])->name('admin.comment.status');
        Route::get('/read-all', [AdminCommentController::class, 'readAll'])->name('admin.comment.readAll');
    });

    //admin/setting
    Route::prefix('setting')->group(function () {
        Route::get('/', [AdminSettingController::class, 'index'])->name('admin.setting.index')->middleware('can:read-setting');
        Route::get('/edit/{setting}', [AdminSettingController::class, 'edit'])->name('admin.setting.edit')->middleware('can:edit-setting');
        Route::put('/update/{setting}', [AdminSettingController::class, 'update'])->name('admin.setting.update')->middleware('can:edit-setting');
    });

    //admin/FAQ
    Route::prefix('faq')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('admin.faq.index');
        Route::get('/show/{faq}', [FaqController::class, 'show'])->name('admin.faq.show');
        Route::get('/create', [FaqController::class, 'create'])->name('admin.faq.create');
        Route::post('/store', [FaqController::class, 'store'])->name('admin.faq.store');
        Route::get('/edit/{faq}', [FaqController::class, 'edit'])->name('admin.faq.edit');
        Route::put('/update/{faq}', [FaqController::class, 'update'])->name('admin.faq.update');
        Route::delete('/destroy/{faq}', [FaqController::class, 'destroy'])->name('admin.faq.destroy');
        Route::get('/status/{faq}', [FaqController::class, 'status'])->name('admin.faq.status');
    });
});


