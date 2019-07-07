<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCat extends Model
{
    //
    public $timestamps=false;  
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image',
        'cat_date',
        'type',
        'title_ar',
        'title_en',
        'description',
        'keywords',
    ];
    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
        'image'=>'required',
        'type'=>'required',
    );
    public function pdfs(){
        return $this->hasMany('App\Pdf');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public function videos(){
        return $this->hasMany('App\Video');
    }
}
