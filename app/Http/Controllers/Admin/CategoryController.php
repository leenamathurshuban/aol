<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\CategoryRequest;
use App\Category;
class CategoryController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=Category::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/Category/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/Category/add');
    }
    public function edit($slug)
    {
    	$data=Category::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/Category/edit',compact('data'));
        }else{
           return redirect()->route('admin.categories')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(CategoryRequest $request,$slug=null)
    {
    	$data=new Category;
    	$data->name=$request->name;
        $data->slug=Str::slug($request->name, '-');
    	if($data->save()){
    		return redirect()->route('admin.categories')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.categories')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(CategoryRequest $request,$slug=null)
    {
        $time=time();
        $data=Category::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->name;
            $data->slug=Str::slug($request->name, '-');
            if($data->save()){
                return redirect()->route('admin.categories')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.categories')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.categories')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=Category::where('slug',$slug)->first();
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
        $data=Category::where('slug',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.categories')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.categories')->with('error', 'Failed ! try again.');
        }
    }
}
