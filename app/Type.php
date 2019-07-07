<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    public $timestamps=false;  
    protected $fillable = [
        'name_en',
        'name_ar',
    ];
    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
    );

    public function units(){
        return $this->hasMany('App\Unit');
    }
}
