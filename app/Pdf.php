<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pdf extends Model
{
    //

    public $timestamps=false;  
    protected $fillable = [
        'media_cat_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'pdf_date',
        'pdf',
    ];
    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
        'pdf'=>'required',
        'media_cat_id'=>'required',
    );
    public function media_cat(){
        return $this->belongsTo('App\MediaCat');
    }
}
