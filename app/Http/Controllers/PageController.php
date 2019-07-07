<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\Project;
use \App\Unit;
use \App\Location;
use \App\Type;
use \App\Offer;
use \App\Contact;
use \App\Subscribe;
use DB;
use Session;
class PageController extends Controller
{
    //
    
    public function index(){
        $this-> handleSession();
        $page=Page::where('name','home')->first();
        

        $primeProjects = Project::where('type','prime')->orderBy('location_id','asc')->orderBy('id','asc')->get();
        $execlusiveProjects = Project::where('type','execlusive')->orderBy('location_id','asc')->orderBy('id','asc')->get();

        $primeLocation = array();
        $execlusiveLocation = array();
        $locations_ar = Location::pluck('name_ar', 'id')->all();
        $locations_en = Location::pluck('name_en', 'id')->all();
        $i=-1;
        foreach($primeProjects as $p){
            if($p->location_id==null){
                $p->location_id=0;
            }
            if($p->location_id!=$i){
                $i=$p->location_id;
                $name_ar='عام';
                $name_en='General';
                if(array_key_exists($i,$locations_ar))
                    $name_ar=$locations_ar[$i];
                if(array_key_exists($i,$locations_en))
                    $name_en=$locations_en[$i];
                $obj = ['id'=>$i,'name_ar'=>$name_ar,'name_en'=>$name_en,'projects'=>array()];
                array_push($primeLocation,$obj);
            }
            array_push($primeLocation[count($primeLocation)-1]['projects'],$p);
        }
        $i=-1;
        foreach($execlusiveProjects as $p){
            if($p->location_id==null){
                $p->location_id=0;
            }
            if($p->location_id!=$i){
                $i=$p->location_id;
                $name_ar='عام';
            $name_en='General';
                if(array_key_exists($i,$locations_ar))
                    $name_ar=$locations_ar[$i];
            if(array_key_exists($i,$locations_en))
                    $name_en=$locations_en[$i];
                $obj = ['id'=>$i,'name_ar'=>$name_ar,'name_en'=>$name_en,'projects'=>array()];
                array_push($execlusiveLocation,$obj);
            }
            array_push($execlusiveLocation[count($execlusiveLocation)-1]['projects'],$p);
        }

        $units = Unit::take(6)->orderBy('id','desc')->where('end_date','>=',DB::raw('CURDATE()'))->get();
        $locations = Location::all();
        $types = Type::all();
        return view('pages.index')->with(['page'=>$page,'primeLocation'=>$primeLocation,'execlusiveLocation'=>$execlusiveLocation,'units'=>$units,'locations'=>$locations,'types'=>$types]);
    }
    public function about(){
        $this-> handleSession();
        $page=Page::where('name','about')->first();
        return view('pages.about')->with(['page'=>$page]);
    }
    public function contact(){
        $this-> handleSession();
        $page=Page::where('name','contact')->first();
        return view('pages.contact')->with(['page'=>$page]);
    }

    public function sitemap()
    {
        $projects = Project::all();
        $units = Unit::all();        
        return response()->view('pages.sitemap', ['projects'=>$projects,'units'=>$units])->withHeaders([
            'Content-Type' => 'text/xml'
        ]);
    }
    public function ar()
    {
        session(['lang' => 'ar']);
        session()->save();
        return back();
    }
    public function en()
    {
        session(['lang' => 'en']);
        session()->save();
        return back();
    }


    public function postContact(Request $request){

        $contact = new Contact;
        $contact->fname = $request->input('fname');
        $contact->lname = $request->input('lname');
        $contact->email = $request->input('email');
        $contact->message = $request->input('message');
        $contact->phone = '';
        $contact->type = 'Contact Form';
        if($contact->save()){
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Your Message sent successfully');
            else
            $request->session()->flash('message', 'تم إرسال رسالتك');
        }
        else{
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Error while handling request');
            else
            $request->session()->flash('message', 'حدث خطأ، برجاء المحاولة مرة اخرى');
        }
        return back();
    }

    public function postSubscribe(Request $request){
        $subscribe = new Subscribe;
        $subscribe->email = $request->input('email');
        $subscribe->save();
        if($subscribe->save()){
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Thanks for your subscribtion');
            else
            $request->session()->flash('message', 'شكراً لتسجيلك معنا');
        }
        else{
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Error while handling request');
            else
            $request->session()->flash('message', 'حدث خطأ، برجاء المحاولة مرة اخرى');
        }
        return back();
    }


    public function postCallme(Request $request){
        $contact = new Contact;
        $contact->fname = $request->input('fname');
        $contact->lname = $request->input('lname');
        $contact->email = $request->input('email');
        $contact->message = '';
        $contact->phone = $request->input('phone');
        $contact->type = 'Call Me Form';
        if($contact->save()){
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Your Message sent successfully');
            else
            $request->session()->flash('message', 'تم إرسال رسالتك');
        }
        else{
            if(app()->getLocale()=='en')
            $request->session()->flash('message', 'Error while handling request');
            else
            $request->session()->flash('message', 'حدث خطأ، برجاء المحاولة مرة اخرى');
        }
        return back();
    }
}
