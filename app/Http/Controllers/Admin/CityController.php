<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use Illuminate\Validation\Rule;
use Illuminate\support\Str;
use App\State;
use App\City;

class CityController extends Controller
{
    function __construct($foo = null)
    {
        $this->paginate = 10;
    }
    public function index($name='',$state='')
    {
        extract($_GET);
        $companies=State::orderBy('name', 'ASC')->pluck('name', 'id');
        $data=City::with('state')->orderBy('name','asc');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        if(isset($state) && !empty($state)){
             $data->where('state_id', $state);
        }
        $total=$data->count();
        $data=$data->select('id','state_id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/city/list',compact('data','name','page','total','companies','state'));

    }

    public function add($value='')
    {
    	$companies=State::orderBy('name', 'ASC')->pluck('name', 'id');
    	return view('admin/city/add',compact('companies'));
    }

    public function edit($slug)
    {
    	$data=City::select('id','state_id','name','slug')->where('slug',$slug)->first();
        if($data){
        	$companies=State::orderBy('name', 'ASC')->pluck('name', 'id');
            return view('admin/city/edit',compact('data','companies'));
        }else{
           return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
        }
    }

    public function insert(CityRequest $request,$slug=null)
    {
    	$time=time();
    	$file='upload/city/';
    	$data=new City;
    	$data->name=$request->name;
    	$data->state_id=$request->state;

    	$companies=State::where('id', $request->state)->first();

        $data->slug=Str::slug($request->name.'-'.$companies->name, '-');
        if($request->image){
        	$imageName=$time.'.'.$request->image->extension();
        	$data->image=$file.$imageName;
        }
    	if($data->save()){
            if($request->image){
    		  $request->image->move(public_path($file),$imageName);
            }
    		return redirect()->route('admin.cities')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
    	}
    }

    public function update(CityRequest $request,$slug=null)
    {
        $time=time();
        $data=City::where('slug',$slug)->first();
        if($data){
        	$m_id=$data->id;
	        $old='';
	        if (isset($data->image)) {
	        	 $old=$data->image;
	        }  
            $pre_img=public_path($data->image);
            $file='upload/city/';
            $data->name=$request->name;
            $data->state_id=$request->state;
            $companies=State::where('id', $request->state)->first();
        	$data->slug=Str::slug($request->name.'-'.$companies->name, '-');
            if($request->image){
                $imageName=$time.'.'.$request->image->extension();
                $data->image=$file.$imageName; 
            }
            if($data->save()){
                if($request->image){
                    if(file_exists($pre_img) && $old){
                        unlink($pre_img);
                    }
                    $request->image->move(public_path($file),$imageName); 
                }
                return redirect()->route('admin.cities')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=City::where('slug',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->route('admin.cities')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $data=City::where('slug',$slug)->first();
        $pre_img=public_path($data->image);
        $file='upload/city/';
        if($data->delete()){
            return redirect()->route('admin.cities')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.cities')->with('error', 'Failed ! try again.');
        }
    }

    public function trashed($name='',$state='')
    {
        extract($_GET);
        $companies=State::orderBy('name', 'ASC')->pluck('name', 'id');
        $data=City::with('state')->onlyTrashed()->orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        if(isset($state) && !empty($state)){
             $data->where('state_id', $state);
        }
        $total=$data->count();
        $data=$data->select('id','state_id','name','slug','status')->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin/city/trashed',compact('data','name','page','total','state','companies'));

    }

    
    public function restore($slug)
    {
        $data=City::withTrashed()->where('slug',$slug)->restore();
        
        if($data){
            return redirect()->route('admin.trashedCities')->with('success', 'Restore successfully !');
        }else{
           return redirect()->route('admin.trashedCities')->with('error', 'Failed ! try again.');
        }
    }
    public function removeTrashed($slug)
    {
        $data=City::withTrashed()->where('slug',$slug)->first();
        $pre_img=public_path($data->image);
        $file='upload/city/';
        if($data->forceDelete()){
            return redirect()->back()->with('success', 'Permanent removed successfully !');
        }else{
           return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
}
