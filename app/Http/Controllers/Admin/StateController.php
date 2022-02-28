<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\StateRequest;
use App\State;
class StateController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=State::orderBy('name','asc');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/state/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/state/add');
    }
    public function edit($slug)
    {
    	$data=State::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/state/edit',compact('data'));
        }else{
           return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(StateRequest $request,$slug=null)
    {
    	$time=time();
    	$file='upload/state/';
    	$data=new State;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
        if($request->image){
        	$imageName=$time.'.'.$request->image->extension();
        	$data->image=$file.$imageName;
        }
    	if($data->save()){
            if($request->image){
    		  $request->image->move(public_path($file),$imageName);
            }
    		return redirect()->route('admin.states')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(StateRequest $request,$slug=null)
    {
        $time=time();
        $data=State::where('slug',$slug)->first();
        $old='';
        if (isset($data->image)) {
        	 $old=$data->image;
        } 
        if($data){
            $pre_img=public_path($data->image);
            $file='upload/state/';
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
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
                
                return redirect()->route('admin.states')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=State::where('slug',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->route('admin.states')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $data=State::where('slug',$slug)->first();
        $pre_img=public_path($data->image);
        $file='upload/state/';
        if($data->delete()){
            return redirect()->route('admin.states')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.states')->with('error', 'Failed ! try again.');
        }
    }

    public function trashed($name='')
    {
        extract($_GET);
        $data=State::onlyTrashed()->orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin/state/trashed',compact('data','name','page','total'));

    }

    
    public function restore($slug)
    {
        $data=State::withTrashed()->where('slug',$slug)->restore();
        
        if($data){
            return redirect()->route('admin.trashedStates')->with('success', 'Restore successfully !');
        }else{
           return redirect()->route('admin.trashedStates')->with('error', 'Failed ! try again.');
        }
    }
    public function removeTrashed($slug)
    {
        $data=State::withTrashed()->where('slug',$slug)->first();
        $pre_img=public_path($data->image);
        $file='upload/state/';
        if($data->forceDelete()){
            return redirect()->back()->with('success', 'Permanent removed successfully !');
        }else{
           return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
}
