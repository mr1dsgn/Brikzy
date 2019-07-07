<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitPhoto extends Model
{
    //
    public $timestamps=false;  
    protected $fillable = [
        'unit_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image',
    ];

    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
        'image'=>'required',
        'unit_id'=>'required',
    );
}
