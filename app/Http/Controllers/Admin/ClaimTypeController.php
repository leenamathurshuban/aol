<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\ClaimTypeRequest;
use App\ClaimType;
class ClaimTypeController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=ClaimType::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status','category')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/claim-type/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/claim-type/add');
    }
    public function edit($slug)
    {
    	$data=ClaimType::select('id','name','slug','category')->where('slug',$slug)->first();
        if($data){
            return view('admin/claim-type/edit',compact('data'));
        }else{
           return redirect()->route('admin.claimTypes')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(ClaimTypeRequest $request,$slug=null)
    {
    	$data=new ClaimType;
    	$data->name=$request->name;
        if($request->category) {
            $data->category=json_encode(array_unique($request->category));
        }
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.claimTypes')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.claimTypes')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(ClaimTypeRequest $request,$slug=null)
    {
        $time=time();
        $data=ClaimType::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->name;
            if($request->category) {
               $data->category=json_encode(array_unique($request->category));
            }
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                return redirect()->route('admin.claimTypes')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.claimTypes')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.claimTypes')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=ClaimType::where('slug',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->back()->with('success', 'Status changed successfully !');
        }else{
           return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $data=ClaimType::where('slug',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.claimTypes')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.claimTypes')->with('error', 'Failed ! try again.');
        }
    }
}
