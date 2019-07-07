<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use View;
use \App\Page;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct(){
        $page=Page::where('name','home')->first();
        View::share('homePage', $page);
    }
    public function handleSession(){
        $lang = session('lang');
        if($lang==null)
            $lang='en';
        app()->setLocale($lang);
    }
}
