<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\PageDetail;
use \App\PageSlide;
use \App\Project;
use \App\ProjectPhoto;
use \App\Unit;
use \App\UnitPhoto;
use \App\Photo;
use \App\Video;
use \App\Pdf;
use \App\MediaCat;
use \App\Location;
use \App\Type;
use \App\User;
use \App\Contact;
use \App\Subscribe;
use Validator;
use Auth;

class AdminController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.index');
    }

    public function pages(){
        $items = Page::all();
        return view('admin.pages.index')->with('items',$items);
    }

    public function pagesview($id){
        $item = Page::findOrFail($id);
        return view('admin.pages.view')->with('item',$item);
    }

    public function pagedetailsview($id){
        $item = PageDetail::findOrFail($id);
        return view('admin.page_details.view')->with('item',$item);
    }
    
    public function pageslidessview($id){
        $item = PageSlide::findOrFail($id);
        return view('admin.page_slides.view')->with('item',$item);
    }

    public function projects(){
        $items = Project::all();
        return view('admin.projects.index')->with('items',$items);
    }
    
    public function projectsview($id){
        $item = Project::findOrFail($id);
        return view('admin.projects.view')->with('item',$item);
    }

    public function projectphotosview($id){
        $item = ProjectPhoto::findOrFail($id);
        return view('admin.project_photos.view')->with('item',$item);
    }

    public function units(){
        $items = Unit::all();
        return view('admin.units.index')->with('items',$items);
    }
    
    public function unitsview($id){
        $item = Unit::findOrFail($id);
        return view('admin.units.view')->with('item',$item);
    }
    
    public function unitphotosview($id){
        $item = UnitPhoto::findOrFail($id);
        return view('admin.unit_photos.view')->with('item',$item);
    }

    public function photos(){
        $items = Photo::all();
        return view('admin.photos.index')->with('items',$items);
    }
    
    public function photosview($id){
        $item = Photo::findOrFail($id);
        return view('admin.photos.view')->with('item',$item);
    }
    
    public function videos(){
        $items = Video::all();
        return view('admin.videos.index')->with('items',$items);
    }
    
    public function videosview($id){
        $item = Video::findOrFail($id);
        return view('admin.videos.view')->with('item',$item);
    }

    public function pdfs(){
        $items = Pdf::all();
        return view('admin.pdfs.index')->with('items',$items);
    }
    
    public function pdfsview($id){
        $item = Pdf::findOrFail($id);
        return view('admin.pdfs.view')->with('item',$item);
    }
    
    public function mediacats(){
        $items =  MediaCat::all();
        return view('admin.media_cats.index')->with('items',$items);
    }
    
    public function mediacatsview($id){
        $item = MediaCat::findOrFail($id);
        return view('admin.media_cats.view')->with('item',$item);
    }

    public function locations(){
        $items = Location::all();
        return view('admin.locations.index')->with('items',$items);
    }
    
    public function types(){
        $items = Type::all();
        return view('admin.types.index')->with('items',$items);
    }

    public function users(){
        $items = User::all();
        return view('admin.users.index')->with('items',$items);
    }

    public function contacts(){
        $items = Contact::all();
        return view('admin.contacts.index')->with('items',$items);
    }

    public function contactsview($id){
        $item = Contact::findOrFail($id);
        return view('admin.contacts.view')->with('item',$item);
    }

    public function subscribes(){
        $items = Subscribe::all();
        return view('admin.subscribes.index')->with('items',$items);
    }

    public function pagesedit($id){
        return view('admin.pages.addedit')->with('item',Page::findOrFail($id));
    }

    public function pagesupdate(Request $request, $id)
    {
        $item = Page::findOrFail($id);
        $item->title_en=$request['title_en'];
        $item->title_ar=$request['title_ar'];
        $item->description=$request['description'];
        $item->keywords=$request['keywords'];
        $item->save();
        return redirect('/admin/pages')->with('success', 'Record has been updated!!');
    }

    public function pagedetailsedit($id){
        return view('admin.page_details.addedit')->with('item',PageDetail::findOrFail($id));
    }

    public function pagedetailsupdate(Request $request, $id)
    {
        $item = PageDetail::findOrFail($id);
        $item->page_value=$request['page_value'];
        $item->save();
        return redirect('/admin/pages/'.$item->page_id)->with('success', 'Record has been updated!!');
    }


    public function pageslidesadd($page_id){
        return view('admin.page_slides.addedit')->with('page_id',$page_id);
    }

    public function pageslidescreate(Request $request)
    {
        $rules = array(
            'url' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.page_slides.addedit')->with('page_id',$request['page_id'])->withErrors($validator);
        } else {
            $item = new PageSlide;
            $item->page_id = $request['page_id'];
            $item->url = $request['url'];
            $item->save();
            return redirect('/admin/pages/'.$item->page_id)->with('success', 'Record has been created!!');
        }
    }

    public function pageslidesedit($id){
        return view('admin.page_slides.addedit')->with('item',PageSlide::findOrFail($id));
    }

    public function pageslidesupdate(Request $request, $id)
    {
        $rules = array(
            'url' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.page_slides.addedit')->with('page_id',$request['page_id'])->withErrors($validator);
        } else {
            $item = PageSlide::findOrFail($id);
            $item->url=$request['url'];
            $item->save();
            return redirect('/admin/pages/'.$item->page_id)->with('success', 'Record has been updated!!');
        }
    }

    public function pageslidesdelete($id)
    {
        $item = PageSlide::findOrFail($id);
        $item->delete();
        return redirect('/admin/pages/'.$item->page_id)->with('success', 'Record has been deleted!!');
    }

    public function projectsadd(){
        return view('admin.projects.addedit')->with('locations',Location::all());
    }
    public function projectscreate(Request $request){
        $rules = array(
            'location_id'=>'required',
            'name_en'=>'required',
            'name_ar'=>'required',
            'image'=>'required',
            'type'=>'required',            
            'lng'=>'numeric',            
            'lng'=>'numeric',            
            'z'=>'numeric',            
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.projects.addedit')->with('locations',Location::all())->withErrors($validator);
        } else {
            $item = new Project;
            $item->location_id=$request['location_id'];
            $item->name_en=$request['name_en'];
            $item->name_ar=$request['name_ar'];
            $item->image=$request['image'];
            $item->type=$request['type'];
            $item->title_ar=$request['title_ar'];
            $item->title_en=$request['title_en'];
            $item->description=$request['description'];
            $item->keywords=$request['keywords'];
            $item->content_ar=$request['content_ar'];
            $item->content_en=$request['content_en'];
            $item->lng=$request['lng'];
            $item->lat=$request['lat'];
            $item->z=$request['z'];
            $item->save();
            return redirect('/admin/projects')->with('success', 'Record has been created!!');
        }
    }
    public function projectsedit($id){
        return view('admin.projects.addedit')->with(['item'=>Project::findOrFail($id),'locations'=>Location::all()]);
    }
    public function projectsupdate(Request $request,$id){
        $rules = array(
            'location_id'=>'required',
            'name_en'=>'required',
            'name_ar'=>'required',
            'image'=>'required',
            'type'=>'required',            
            'lng'=>'numeric',            
            'lng'=>'numeric',            
            'z'=>'numeric',            
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.projects.addedit')->with(['item'=>Project::findOrFail($id),'locations'=>Location::all()])->withErrors($validator);
        } else {
            $item = Project::findOrFail($id);
            $item->location_id=$request['location_id'];
            $item->name_en=$request['name_en'];
            $item->name_ar=$request['name_ar'];
            $item->image=$request['image'];
            $item->type=$request['type'];
            $item->title_ar=$request['title_ar'];
            $item->title_en=$request['title_en'];
            $item->description=$request['description'];
            $item->keywords=$request['keywords'];
            $item->content_ar=$request['content_ar'];
            $item->content_en=$request['content_en'];
            $item->lng=$request['lng'];
            $item->lat=$request['lat'];
            $item->z=$request['z'];
            $item->save();
            return redirect('/admin/projects')->with('success', 'Record has been updated!!');
        }
    }
    public function projectsdelete($id){
        $item = Project::findOrFail($id);
        if($item->units()->count()>0){
            return redirect('/admin/projects')->with('error', 'Record cannot be deleted, It has related childs');
        }
        $photos = $item->photos()->get();
        foreach($photos as $photo){
            $photo->delete();
        }
        $item->delete();
        return redirect('/admin/projects')->with('success', 'Record has been deleted!!');
    }

    public function project_photosadd($project_id){
        return view('admin.project_photos.addedit')->with('project_id',$project_id);
    }
    public function project_photoscreate(Request $request){
        $rules = array(
            'image'=>'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.project_photos.addedit')->with('project_id',$request['project_id'])->withErrors($validator);
        } else {
            $item = new ProjectPhoto;
            $item->project_id=$request['project_id'];
            $item->name_en=$request['name_en'];
            $item->name_ar=$request['name_ar'];
            $item->image=$request['image'];
            $item->description_en=$request['description_en'];
            $item->description_ar=$request['description_ar'];
            $item->save();
            return redirect('/admin/projects/'.$item->project_id)->with('success', 'Record has been created!!');
        }
    }
    public function project_photosedit($id){
        return view('admin.project_photos.addedit')->with('item',ProjectPhoto::findOrFail($id));
    }
    public function project_photosupdate(Request $request,$id){
        $rules = array(
            'image'=>'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return view('admin.project_photos.addedit')->with('project_id',$request['project_id'])->withErrors($validator);
        } else {
            $item = ProjectPhoto::findOrFail($id);
            $item->name_en=$request['name_en'];
            $item->name_ar=$request['name_ar'];
            $item->image=$request['image'];
            $item->description_en=$request['description_en'];
            $item->description_ar=$request['description_ar'];
            $item->save();
            return redirect('/admin/projects/'.$item->project_id)->with('success', 'Record has been updated!!');
        }
    }
    public function project_photosdelete($id){
        $item = ProjectPhoto::findOrFail($id);
        $item->delete();
        return redirect('/admin/projects/'.$item->project_id)->with('success', 'Record has been deleted!!');
    }

    public function unitsadd(){
        return view('admin.units.addedit')->with([
            'locations'=>Location::all(),
            'projects'=>Project::all(),
            'types'=>Type::all()
        ]);
    }
    public function unitscreate(Request $request){
        $item = new Unit;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.units.addedit')->with(['locations'=>Location::all(),'projects'=>Project::all(),'types'=>Type::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/units')->with('success', 'Record has been created!!');
        }
    }
    public function unitsedit($id){
        return view('admin.units.addedit')->with(['item'=>Unit::findOrFail($id),'locations'=>Location::all(),'projects'=>Project::all(),'types'=>Type::all()]);
    }
    public function unitsupdate(Request $request,$id){
        $item = Unit::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.units.addedit')->with(['item'=>Unit::findOrFail($id),'locations'=>Location::all(),'projects'=>Project::all(),'types'=>Type::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/units')->with('success', 'Record has been updated!!');
        }
    }
    public function unitsdelete($id){
        $item = Unit::findOrFail($id);
        $photos = $item->photos()->get();
        foreach($photos as $photo){
            $photo->delete();
        }
        $item->delete();
        return redirect('/admin/units')->with('success', 'Record has been deleted!!');
    }

    public function unit_photosadd($unit_id){
        return view('admin.unit_photos.addedit')->with('unit_id',$unit_id);
    }
    public function unit_photoscreate(Request $request){
        $item = new UnitPhoto;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.unit_photos.addedit')->with('unit_id',$request['unit_id'])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/units/'.$request['unit_id'])->with('success', 'Record has been created!!');
        }
    }
    public function unit_photosedit($id){
        return view('admin.unit_photos.addedit')->with('item',UnitPhoto::findOrFail($id));
    }
    public function unit_photosupdate(Request $request,$id){
        $item = UnitPhoto::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.unit_photos.addedit')->with('unit_id',$request['unit_id'])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/units/'.$item->unit_id)->with('success', 'Record has been updated!!');
        }
    }
    public function unit_photosdelete($id){
        $item = UnitPhoto::findOrFail($id);
        $item->delete();
        return redirect('/admin/units/'.$item->unit_id)->with('success', 'Record has been deleted!!');
    }

    public function photosadd(){
        return view('admin.photos.addedit')->with(['media_cats'=>MediaCat::all()]);
    }
    public function photoscreate(Request $request){
        $item = new Photo;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin..addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/photos')->with('success', 'Record has been created!!');
        }
    }
    public function photosedit($id){
        return view('admin.photos.addedit')->with(['media_cats'=>MediaCat::all(),'item'=>Photo::findOrFail($id)]);
    }
    public function photosupdate(Request $request,$id){
        $item = Photo::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.photos.addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/photos')->with('success', 'Record has been updated!!');
        }
    }
    public function photosdelete($id){
        $item = Photo::findOrFail($id);
        $item->delete();
        return redirect('/admin/photos')->with('success', 'Record has been deleted!!');
    }

    public function videosadd(){
        return view('admin.videos.addedit')->with(['media_cats'=>MediaCat::all()]);;
    }
    public function videoscreate(Request $request){
        $item = new Video;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.videos.addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/videos')->with('success', 'Record has been created!!');
        }
    }
    public function videosedit($id){
        return view('admin.videos.addedit')->with(['media_cats'=>MediaCat::all(),'item'=>Video::findOrFail($id)]);
    }
    public function videosupdate(Request $request,$id){
        $item = Video::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.videos.addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/videos')->with('success', 'Record has been updated!!');
        }
    }
    public function videosdelete($id){
        $item = Video::findOrFail($id);
        $item->delete();
        return redirect('/admin/videos')->with('success', 'Record has been deleted!!');
    }

    public function pdfsadd(){
        return view('admin.pdfs.addedit')->with(['media_cats'=>MediaCat::all()]);
    }
    public function pdfscreate(Request $request){
        $item = new Pdf;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.pdfs.addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/pdfs')->with('success', 'Record has been created!!');
        }
    }
    public function pdfsedit($id){
        return view('admin.pdfs.addedit')->with(['item'=>Pdf::findOrFail($id),'media_cats'=>MediaCat::all()]);
    }
    public function pdfsupdate(Request $request,$id){
        $item = Pdf::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.pdfs.addedit')->with(['media_cats'=>MediaCat::all()])->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/pdfs')->with('success', 'Record has been updated!!');
        }
    }
    public function pdfsdelete($id){
        $item = Pdf::findOrFail($id);
        $item->delete();
        return redirect('/admin/pdfs')->with('success', 'Record has been deleted!!');
    }

    public function media_catsadd(){
        return view('admin.media_cats.addedit');
    }
    public function media_catscreate(Request $request){
        $item = new MediaCat;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.media_cats.addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/media_cats')->with('success', 'Record has been created!!');
        }
    }
    public function media_catsedit($id){
        return view('admin.media_cats.addedit')->with('item',MediaCat::findOrFail($id));
    }
    public function media_catsupdate(Request $request,$id){
        $item = MediaCat::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.media_cats.addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/media_cats')->with('success', 'Record has been updated!!');
        }
    }
    public function media_catsdelete($id){
        $item = MediaCat::findOrFail($id);
        if($item->photos()->count()>0 || $item->videos()->count()>0 || $item->pdfs()->count()>0){
            return redirect('/admin/media_cats')->with('error', 'Record cannot be deleted, It has related childs');
        }
        $item->delete();
        return redirect('/admin/media_cats')->with('success', 'Record has been deleted!!');
    }

    public function locationsadd(){
        return view('admin.locations.addedit');
    }
    public function locationscreate(Request $request){
        $item = new Location;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.locations.addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/locations')->with('success', 'Record has been created!!');
        }
    }
    public function locationsedit($id){
        return view('admin.locations.addedit')->with('item',Location::findOrFail($id));
    }
    public function locationsupdate(Request $request,$id){
        $item = Location::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.............addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/locations')->with('success', 'Record has been updated!!');
        }
    }
    public function locationsdelete($id){
        $item = Location::findOrFail($id);
        if($item->projects()->count()>0 ||$item->units()->count()>0){
            return redirect('/admin/locations')->with('error', 'Record cannot be deleted, It has related childs');
        }
        $item->delete();
        return redirect('/admin/locations')->with('success', 'Record has been deleted!!');
    }

    public function typesadd(){
        return view('admin.types.addedit');
    }
    public function typescreate(Request $request){
        $item = new Type;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.types.addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/types')->with('success', 'Record has been created!!');
        }
    }
    public function typesedit($id){
        return view('admin.types.addedit')->with('item',Type::findOrFail($id));
    }
    public function typesupdate(Request $request,$id){
        $item = Type::findOrFail($id);
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.types.addedit')->withErrors($validator);
        } else {
            $item->fill($request->only($item->getFillable()))->save();
            return redirect('/admin/types')->with('success', 'Record has been updated!!');
        }
    }
    public function typesdelete($id){
        $item = Type::findOrFail($id);
        if($item->units()->count()>0){
            return redirect('/admin/types')->with('error', 'Record cannot be deleted, It has related childs');
        }
        $item->delete();
        return redirect('/admin/types')->with('success', 'Record has been deleted!!');
    }

    public function usersadd(){
        return view('admin.users.addedit');
    }
    public function userscreate(Request $request){
        $item = new User;
        $validator = Validator::make($request->all(), $item->rules);
        if ($validator->fails()) {
            return view('admin.users.addedit')->withErrors($validator);
        } else {
            $item->name=$request['name'];
            $item->email=$request['email'];
            $item->password=bcrypt($request['password']);
            $item->save();
            return redirect('/admin/users')->with('success', 'Record has been created!!');
        }
    }
    public function usersdelete($id){
        $item = User::findOrFail($id);
        if($item->id == Auth::user()->id){
            return redirect('/admin/users')->with('error', 'You cannot delete yourself!!');
        }
        $item->delete();
        return redirect('/admin/users')->with('success', 'Record has been deleted!!');
    }

    public function contactsdelete($id){
        $item = Contact::findOrFail($id);
        $item->delete();
        return redirect('/admin/contacts')->with('success', 'Record has been deleted!!');
    }

    public function subscribesdelete($id){
        $item = Subscribe::findOrFail($id);
        $item->delete();
        return redirect('/admin/subscribes')->with('success', 'Record has been deleted!!');
    }
}