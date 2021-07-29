<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
        Inertia::share('locale', function () {
            return app()->getLocale();
        });
        Inertia::share('language', function () {
            return translations(
                resource_path('/lang/' . app()->getLocale() . '.json')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('delete_update_post',function($user,Post $post){
            return $user->id==$post->user->id;
        });

    }
}
