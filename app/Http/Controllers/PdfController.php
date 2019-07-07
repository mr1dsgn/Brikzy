<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\MediaCat;
class PdfController extends Controller
{
    //
    public function index(){
        $this-> handleSession();
        $page=Page::where('name','pdfs')->first();
        $media_cats=MediaCat::where('type','pdf')->get();
        return view('pdfs.index')->with(['page'=>$page,'media_cats'=>$media_cats]);
    }
}
