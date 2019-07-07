<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\Project;
use \App\Location;
class ProjectController extends Controller
{
    //
    public function index(){
        $this-> handleSession();
        $page=Page::where('name','projects')->first();
        
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
        return view('projects.index')->with(['page'=>$page,'primeLocation'=>$primeLocation,'execlusiveLocation'=>$execlusiveLocation]);
    }

    public function view($id){
        $this-> handleSession();
        $page=Page::where('name','projects')->first();
        $project = Project::findOrFail($id);
        if($project->title_ar=='')
            $page->title_ar=$project->name_ar;
        else
            $page->title_ar=$page->title_ar;
        if($project->title_en=='')
            $page->title_en=$project->name_en;
        else
            $page->title_en=$project->title_en;
        if($project->description!='')
            $page->description=$project->description;
        if($project->keywords!='')
            $page->keywords=$project->keywords;
        return view('projects.view')->with(['page'=>$page,'project'=>$project]);
    }
}