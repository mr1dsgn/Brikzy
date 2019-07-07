<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    public $timestamps=false;
    public function page_details(){
        return $this->hasMany('App\PageDetail');
    }
    
    public function details(){
        return $this->hasMany('App\PageDetail')->pluck('page_value', 'page_key')->toArray();
    }

    public function slides(){
        return $this->hasMany('App\PageSlide');
    }
}
