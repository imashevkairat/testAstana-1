<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\View;
use App\Models\Companies;

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
        view()->composer('*', function(View $view) {

            if (auth()->user()){
                $my_companies = Companies::on()->where('auth_id',auth()->user()->getAuthIdentifier())->get()->toArray();
            }else{
                $my_companies = ['Добавить компанию'];
            }


            $view->with('my_companies', $my_companies);


        });
    }
}
