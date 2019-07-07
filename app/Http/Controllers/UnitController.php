<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\Unit;
use DB;
class UnitController extends Controller
{
    //
    public function index(Request $request){
        $this-> handleSession();
        $page=Page::where('name','units')->first();
        $units = Unit::orderBy('id','asc');
        if(!empty($request['keywords']))
            $units = $units->where('name_en','like',$request['keywords'])->orWhere('name_ar','like',$request['keywords'])->orWhere('description_en','like',$request['keywords'])->orWhere('description_ar','like',$request['keywords']);
        if(!empty($request['type']))
            $units = $units->where('type_id',$request['type']);
        if(!empty($request['priceFrom']))
            $units = $units->where('price','>=',$request['priceFrom']);
        if(!empty($request['priceTo']))
            $units = $units->where('price','<=',$request['priceTo']);
        if(!empty($request['areaFrom']))
            $units = $units->where('area','>=',$request['areaFrom']);
        if(!empty($request['areaTo']))
            $units = $units->where('area','<=',$request['areaTo']);
        if(!empty($request['location']))
            $units = $units->where('location_id',$request['location']);
        if(!empty($request['garages']))
            $units = $units->where('garages',$request['garages']);
        if(!empty($request['bathrooms']))
            $units = $units->where('baths',$request['bathrooms']);
        if(!empty($request['bedrooms']))
            $units = $units->where('beds',$request['bedrooms']);
        $units = $units->get();
        return view('units.index')->with(['page'=>$page,'units'=>$units]);
    }

    public function view($id){
        $this-> handleSession();
        $page=Page::where('name','units')->first();
        $unit = Unit::findOrFail($id);
        if($unit->title_ar=='')
            $page->title_ar=$unit->name_ar;
        else
            $page->title_ar=$page->title_ar;
        if($unit->title_en=='')
            $page->title_en=$unit->name_en;
        else
            $page->title_en=$unit->title_en;
        if($unit->description!='')
            $page->description=$unit->description;
        if($unit->keywords!='')
            $page->keywords=$unit->keywords;
        return view('units.view')->with(['page'=>$page,'unit'=>$unit]);
    }

    //
    public function indexoffer(){
        $this-> handleSession();
        $page=Page::where('name','offers')->first();
        $units = Unit::orderBy('id','asc');
        $units = $units->where('end_date','>=',DB::raw('CURDATE()'));
        $units = $units->get();
        return view('offers.index')->with(['page'=>$page,'units'=>$units]);
    }

    public function viewoffer($id){
        $this-> handleSession();
        $page=Page::where('name','offers')->first();
        $unit = Unit::findOrFail($id);
        if($unit->title_ar=='')
            $page->title_ar=$unit->name_ar;
        else
            $page->title_ar=$page->title_ar;
        if($unit->title_en=='')
            $page->title_en=$unit->name_en;
        else
            $page->title_en=$unit->title_en;
        if($unit->description!='')
            $page->description=$unit->description;
        if($unit->keywords!='')
            $page->keywords=$unit->keywords;
        return view('offers.view')->with(['page'=>$page,'unit'=>$unit]);
    }
}
