<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    public $timestamps=false;  
    protected $fillable = [
        'media_cat_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'video',
    ];

    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
        'video'=>'required',
        'media_cat_id'=>'required',
    );
    public function media_cat(){
        return $this->belongsTo('App\MediaCat');
    }
}
