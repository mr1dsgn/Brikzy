<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public $timestamps=false;
    public function photos(){
        return $this->hasMany('App\ProjectPhoto');
    }

    public function units(){
        return $this->hasMany('App\Unit');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }
    
}
