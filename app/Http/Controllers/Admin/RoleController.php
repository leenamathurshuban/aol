<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\RoleRequest;
use App\Role;
class RoleController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=Role::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/role/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/role/add');
    }
    public function edit($slug)
    {
    	$data=Role::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/role/edit',compact('data'));
        }else{
           return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(RoleRequest $request,$slug=null)
    {
    	$data=new Role;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.roles')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(RoleRequest $request,$slug=null)
    {
        $time=time();
        $data=Role::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                return redirect()->route('admin.roles')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.roles')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=Role::where('slug',$slug)->first();
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
        return redirect()->back()->with('error', 'Failed ! try again.');
    }

}
