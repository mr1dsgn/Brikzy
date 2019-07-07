<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Location;
class Unit extends Model
{
    //
    public $timestamps=false;  
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image',
        'beds',
        'baths',
        'garages',
        'location_id',
        'project_id',
        'type_id',
        'area',
        'price',
        'title_ar',
        'title_en',
        'description',
        'keywords',
        'end_date',
        'offer_name_en',
        'offer_name_ar',
    ];

    public $rules=array(
        'name_en'=>'required',
        'name_ar'=>'required',
        'image'=>'required',
        'beds'=>'required',
        'baths'=>'required',
        'garages'=>'required',
        'location_id'=>'required',        
        'type_id'=>'required',
        'area'=>'required',
        'price'=>'required',
    );
    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function type(){
        return $this->belongsTo('App\Type');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
    //
    public function photos(){
        return $this->hasMany('App\UnitPhoto');
    }
    
}
