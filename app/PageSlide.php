<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageSlide extends Model
{
    //
    public $timestamps=false;
    
    public function page(){
        return $this->belongsTo('App\Page');
    }
}
