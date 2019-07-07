<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\MediaCat;
class PhotoController extends Controller
{
    //
    public function index(){
        $this-> handleSession();
        $page=Page::where('name','photos')->first();
        $media_cats=MediaCat::where('type','photo')->get();
        return view('photos.index')->with(['page'=>$page,'media_cats'=>$media_cats]);
    }
    public function view($id){
        $this-> handleSession();
        $page=Page::where('name','photos')->first();
        $media_cat = MediaCat::findOrFail($id);
        if($media_cat->title_ar=='')
            $page->title_ar=$media_cat->name_ar;
        else
            $page->title_ar=$page->title_ar;
        if($media_cat->title_en=='')
            $page->title_en=$media_cat->name_en;
        else
            $page->title_en=$media_cat->title_en;
        if($media_cat->description!='')
            $page->description=$media_cat->description;
        if($media_cat->keywords!='')
            $page->keywords=$media_cat->keywords;
        return view('photos.view')->with(['page'=>$page,'media_cat'=>$media_cat]);
    }
}
