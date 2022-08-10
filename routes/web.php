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
    Route::prefix('user')->controller(LoginRegisterConteroller::class)->group(function () {
        Route::get('login-register-form', 'LoginRegisterForm')->name('auth.user.login-register-form');
        Route::middleware('throttle:user-login-register-limiter')->post('login-register','LoginRegister')->name('auth.user.login-register');

        Route::get('login-register-confirm-form/{token}','LoginRegisterConfirmForm')->name('auth.user.login-register-confirm-form');
        Route::middleware('throttle:user-login-register-confirm-limiter')->post('login-register-confirm/{token}','LoginRegisterConfirm')->name('auth.user.login-register-confirm');
        Route::middleware('throttle:user-login-register-resend-otp-limiter')->get('login-register-resend-otp/{token}', 'LoginRegisterResendOtp')->name('auth.user.login-register-resend-otp');
        Route::get('logout','Logout')->name('auth.user.logout')->withoutMiddleware('guest');
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
    Route::prefix('account')->controller(UserAccountController::class)->group(function () {
        Route::get('dashboard','index')->name('user.account.dashboard');
        Route::post('edit-profile-image', 'EditProfileImage')->name('user.account.edit-profile-image');
        Route::post('edit-account-info', 'EditAccountInfo')->name('user.account.edit-account-info');
    });
});


Route::middleware(['auth' , 'IsAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.home');
    //admin/animals
    Route::middleware('can:read-animal')->prefix('animal')->controller(AnimalController::class)->group(function () {
        Route::get('/' , 'index')->name('admin.animal.index');
        Route::get('show/{animal}', 'show')->name('admin.animal.show');
        Route::get('/create', 'create')->name('admin.animal.create')->middleware('can:create-animal');
        Route::post('/store','store')->name('admin.animal.store')->middleware('can:create-animal');
        Route::get('/edit/{animal}','edit')->name('admin.animal.edit')->middleware('can:edit-animal');
        Route::put('/update/{animal}', 'update')->name('admin.animal.update')->middleware('can:edit-animal');
        Route::delete('/destroy/{animal}','destroy')->name('admin.animal.destroy')->middleware('can:delete-animal');
        Route::get('/status/{animal}','status')->name('admin.animal.status')->middleware('can:edit-animal');
        Route::get('/search', 'search')->name('admin.animal.search');

        //animal/attribute
        Route::prefix('meta')->controller(AnimalMetaController::class)->group(function () {
            Route::post('update/{meta}', 'update')->name('admin.animal.meta.update');
            Route::delete('destroy/{meta}' ,  'destroy')->name('admin.animal.meta.destroy');
            Route::post('{animal}/store', 'store')->name('admin.animal.meta.store');
        });
        //animal/image
        Route::prefix('gallery')->controller(AnimalGalleryController::class)->group(function () {
            Route::get('/', 'allGallery')->name('admin.animal.gallery.allGallery');
            Route::get('/{animal}', 'index')->name('admin.animal.gallery.index');
            Route::delete('destroy/{image}', 'destroy')->name('admin.animal.image.destroy');
            Route::delete('destroyGallery/{animal}','destroyGallery')->name('admin.animal.gallery.destroy');
            Route::get('status/{image}' , 'status')->name('admin.animal.image.status');
            Route::post('{animal}/store','store')->name('admin.animal.image.store');
        });

        //animal/category
        Route::prefix('category')->controller(AnimalCategoryController::class )->group(function () {
            Route::get('/', 'index')->name('admin.animal.category.index');
            Route::get('/show/{category}', 'show')->name('admin.animal.category.show');
            Route::get('/create',  'create')->name('admin.animal.category.create');
            Route::post('/store', 'store')->name('admin.animal.category.store');
            Route::get('/edit/{category}','edit')->name('admin.animal.category.edit');
            Route::put('/update/{category}', 'update')->name('admin.animal.category.update');
            Route::delete('/destroy/{category}', 'destroy')->name('admin.animal.category.destroy');
            Route::get('/status/{category}', 'status')->name('admin.animal.category.status');
        });

        //animal/protective-status
        Route::prefix('protective-status')->controller(AnimalProtectiveStatusController::class)->group(function () {
            Route::get('/', 'index')->name('admin.animal.protectiveStatus.index');
            Route::post('/store', 'store')->name('admin.animal.protectiveStatus.store');
            Route::get('/edit/{status}', 'edit')->name('admin.animal.protectiveStatus.edit');
            Route::put('/update/{status}', 'update')->name('admin.animal.protectiveStatus.update');
            Route::delete('/destroy/{status}', 'destroy')->name('admin.animal.protectiveStatus.destroy');
            Route::get('/status/{status}', 'status')->name('admin.animal.protectiveStatus.status');
        });
    });


    //admin/content
    Route::prefix('content')->group(function () {
        //content/menu
        Route::prefix('menu')->controller(ContentMenuController::class)->group(function () {
            Route::get('/', 'index')->name('admin.content.menu.index');
            Route::get('/create', 'create')->name('admin.content.menu.create');
            Route::post('/store', 'store')->name('admin.content.menu.store');
            Route::get('/edit/{menu}','edit')->name('admin.content.menu.edit');
            Route::put('/update/{menu}','update')->name('admin.content.menu.update');
            Route::delete('/destroy/{menu}', 'destroy')->name('admin.content.menu.destroy');
            Route::get('/status/{menu}', 'status')->name('admin.content.menu.status');
        });

        //content/slider
        Route::prefix('slider')->controller(ContentSliderController::class)->group(function () {
            Route::get('/', 'index')->name('admin.content.slider.index');
            Route::get('/create', 'create')->name('admin.content.slider.create');
            Route::post('/store',  'store')->name('admin.content.slider.store');
            Route::get('/edit/{slider}', 'edit')->name('admin.content.slider.edit');
            Route::put('/update/{slider}', 'update')->name('admin.content.slider.update');
            Route::delete('/destroy/{slider}', 'destroy')->name('admin.content.slider.destroy');
            Route::get('/status/{slider}', 'status')->name('admin.content.slider.status');
        });

        //content/page
        Route::prefix('page')->controller(ContentPageController::class)->group(function () {
            Route::get('/', 'index')->name('admin.content.page.index');
            Route::get('/create', 'create')->name('admin.content.page.create');
            Route::post('/store', 'store')->name('admin.content.page.store');
            Route::get('/edit/{page}', 'edit')->name('admin.content.page.edit');
            Route::put('/update/{page}', 'update')->name('admin.content.page.update');
            Route::delete('/destroy/{page}', 'destroy')->name('admin.content.page.destroy');
            Route::get('/status/{page}', 'status')->name('admin.content.page.status');
        });
    });
    //admin/users
    Route::middleware(['role:superAdmin'])->prefix('user')->group(function () {
        //managers
        Route::prefix('manager')->controller(ManagerController::class)->group(function () {
            Route::get('/', 'index')->name('admin.manager.index');
            Route::get('/create','create')->name('admin.manager.create');
            Route::post('/store', 'store')->name('admin.manager.store');
            Route::get('/edit/{admin}', 'edit')->name('admin.manager.edit');
            Route::put('/update/{admin}', 'update')->name('admin.manager.update');
            Route::delete('/destroy/{admin}', 'destroy')->name('admin.manager.destroy');
            Route::get('/status/{admin}', 'status')->name('admin.manager.status');

            Route::get('/{admin}/role', [ManagerRoleController::class, 'editRole'])->name('admin.manager.editRole');
            Route::post('/{admin}/role/update', [ManagerRoleController::class, 'updateRole'])->name('admin.manager.updateRole');
        });

        //users
        Route::prefix('user')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('admin.user.index');
            Route::get('/create', 'create')->name('admin.user.create');
            Route::post('/store', 'store')->name('admin.user.store');
            Route::get('/edit/{user}','edit')->name('admin.user.edit');
            Route::put('/update/{user}','update')->name('admin.user.update');
            Route::delete('/destroy/{user}', 'destroy')->name('admin.user.destroy');
            Route::get('/status/{user}', 'status')->name('admin.user.status');
        });

        //ACL / role
        Route::prefix('role')->controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->name('admin.role.index');
            Route::get('/create', 'create')->name('admin.role.create');
            Route::post('/store', 'store')->name('admin.role.store');
            Route::get('/edit/{role}',  'edit')->name('admin.role.edit');
            Route::put('/update/{role}',  'update')->name('admin.role.update');
            Route::delete('/destroy/{role}',  'destroy')->name('admin.role.destroy');
            Route::get('/status/{role}',  'status')->name('admin.role.status');

        });
    });

    //admin/comment
    Route::middleware('can:read-comment')->prefix('comment')->controller(AdminCommentController::class)->group(function () {
        Route::get('/', 'index')->name('admin.comment.index');
        Route::get('/unseen-comment','unseenComment')->name('admin.comment.unseenComment');
        Route::get('/show/{comment}', 'show')->name('admin.comment.show');
        Route::post('/answer/{comment}', 'answer')->name('admin.comment.answer');
        Route::put('/update/{comment}', 'update')->name('admin.comment.update');
        Route::delete('/destroy/{comment}', 'destroy')->name('admin.comment.destroy');
        Route::get('/status/{comment}', 'status')->name('admin.comment.status');
        Route::get('/read-all','readAll')->name('admin.comment.readAll');
    });

    //admin/setting
    Route::prefix('setting')->controller(AdminSettingController::class)->group(function () {
        Route::get('/', 'index')->name('admin.setting.index')->middleware('can:read-setting');
        Route::get('/edit/{setting}', 'edit')->name('admin.setting.edit')->middleware('can:edit-setting');
        Route::put('/update/{setting}', 'update')->name('admin.setting.update')->middleware('can:edit-setting');
    });

    //admin/FAQ
    Route::prefix('faq')->controller(FaqController::class)->group(function () {
        Route::get('/', 'index')->name('admin.faq.index');
        Route::get('/show/{faq}','show')->name('admin.faq.show');
        Route::get('/create', 'create')->name('admin.faq.create');
        Route::post('/store' , 'store')->name('admin.faq.store');
        Route::get('/edit/{faq}', 'edit')->name('admin.faq.edit');
        Route::put('/update/{faq}', 'update')->name('admin.faq.update');
        Route::delete('/destroy/{faq}', 'destroy')->name('admin.faq.destroy');
        Route::get('/status/{faq}','status')->name('admin.faq.status');
    });
});


