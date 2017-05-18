<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

            view()->composer('master', function ($view)
            {   
                if(request()->user()){
                $user = request()->user();
                $notifications = \App\Notification::where('user_id',$user->id)->where('is_read',0)->count();
                }else{
                     $notifications = 0;
                }
         
                $view->with('notcount', $notifications);
            });
        

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
