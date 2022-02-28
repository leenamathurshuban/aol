<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\ApexRequest;
use App\Apex;
class ApexController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=Apex::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/apex/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/apex/add');
    }
    public function edit($slug)
    {
    	$data=Apex::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/apex/edit',compact('data'));
        }else{
           return redirect()->route('admin.apexs')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(ApexRequest $request,$slug=null)
    {
    	$data=new Apex;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.apexs')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.apexs')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(ApexRequest $request,$slug=null)
    {
        $time=time();
        $data=Apex::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                return redirect()->route('admin.apexs')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.apexs')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.apexs')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=Apex::where('slug',$slug)->first();
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
        //return redirect()->back()->with('error', 'Failed ! try again.');
        $data=Apex::where('slug',$slug)->first();
        $id=$data->id;
        if($data->delete()){
            \App\BankAccount::where('apexe_id',$id)->delete();
            return redirect()->route('admin.apexs')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.apexs')->with('error', 'Failed ! try again.');
        }
    }
}
