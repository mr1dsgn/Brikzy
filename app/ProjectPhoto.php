<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectPhoto extends Model
{
    //
    public $timestamps=false;
    public function project(){
        return $this->belongsTo('App\Project');
    }
}
