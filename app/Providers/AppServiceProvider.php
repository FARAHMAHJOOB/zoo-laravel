<?php

namespace App\Providers;

use App\Models\Admin\Content\Menu;
use App\Models\Admin\Setting\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        view()->composer(['user.layouts.header' , 'user.auth.login-register' , 'user.auth.login-register-confirm'] , function($view){
            $view->with('setting' , Setting::first());
            $view->with('menus' , Menu::where('status' , 1)->where('parent_id', null)->get());
        });

    }
}
