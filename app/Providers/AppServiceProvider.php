<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;


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
        $data  = GeneralSetting::first();

        $result = array(
                        'gs_phone'      => "(".substr($data->phone, 0, 3).") ".substr($data->phone, 3, 3)."-".substr($data->phone,6),
                        'gs_email'      => $data->email,
                        'gs_website'    => $data->website,
                        'gs_location'   => $data->location,
                );

         view()->share('gs_info',$result);
    }
}
