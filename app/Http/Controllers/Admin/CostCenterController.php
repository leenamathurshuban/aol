<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\CostCenterRequest;
use App\CostCenter;
class CostCenterController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=CostCenter::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/CostCenter/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/CostCenter/add');
    }
    public function edit($slug)
    {
    	$data=CostCenter::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/CostCenter/edit',compact('data'));
        }else{
           return redirect()->route('admin.cost_centers')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(CostCenterRequest $request,$slug=null)
    {
    	$data=new CostCenter;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.cost_centers')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.cost_centers')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(CostCenterRequest $request,$slug=null)
    {
        $time=time();
        $data=CostCenter::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                return redirect()->route('admin.cost_centers')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.cost_centers')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.cost_centers')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=CostCenter::where('slug',$slug)->first();
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
        $data=CostCenter::where('slug',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.cost_centers')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.cost_centers')->with('error', 'Failed ! try again.');
        }
    }
}
