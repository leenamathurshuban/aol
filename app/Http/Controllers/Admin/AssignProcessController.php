<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AssignProcessRequest;
use Illuminate\support\Str;

use App\AssignProcess;

class AssignProcessController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=AssignProcess::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/assign_process/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/assign_process/add');
    }
    public function edit($slug)
    {
    	$data=AssignProcess::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/assign_process/edit',compact('data'));
        }else{
           return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(AssignProcessRequest $request,$slug=null)
    {
    	$data=new AssignProcess;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.assignProcess')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.assignProcess')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(AssignProcessRequest $request,$slug=null)
    {
        $time=time();
        $data=AssignProcess::where('slug',$slug)->first();
        if($data){
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                
                return redirect()->route('admin.assignProcess')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.assignProcess')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.assignProcess')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
        $data=AssignProcess::where('slug',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->back()->with('success', 'Status changed successfully !');
        }else{
           return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function removeTrashed($slug)
    {
        $data=AssignProcess::where('slug',$slug)->first();
        if($data->forceDelete()){
            return redirect()->back()->with('success', 'Permanent removed successfully !');
        }else{
           return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }
}
