<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // ⬅️ WAJIB, HURUF BESAR
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with(
                'navCategories',
                Category::orderBy('name')->get()
            );
        });
    }
}
