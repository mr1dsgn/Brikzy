<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Page;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('layouts.app', function ($view) {
            $contactPage=Page::where('name','contact')->first();
            $aboutPage=Page::where('name','about')->first();
            $propResults = DB::select('SELECT l.*,IFNULL(vt.vc,0) vcount FROM locations l left join (select units.location_id,count(0) as vc from units group by units.location_id) vt on vt.location_id = l.id order by vt.vc desc LIMIT 0,5');
            $view->with( ['contactPage'=>$contactPage,'aboutPage'=>$aboutPage,'propResults'=>$propResults ]);
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
