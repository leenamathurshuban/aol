<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Str;
use App\User;
use Auth;
class UserController extends Controller
{
    function __construct($foo = null)
    {
    	$this->paginate = 10;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this->companykey=substr(str_shuffle($permitted_chars), 0, 6);
    }
    public function index($name='') 
    {
        extract($_GET);
        $data=User::orderBy('name','asc')->where(['is_admin'=>'2']);
    	if (isset($name) && $name) {
    		$data->where('name', 'LIKE', "%$name%");
    	}
        $total=$data->count();
    	$data = $data->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/company/list',compact('data','name','page','total'));
    }
    public function delete($value='')
    {
        $data=User::where('id',$value)->where(['is_admin'=>'2'])->first();
        $preImage='';
        if ($data->image) {
            $preImage=$data->image;
            $existsImage=public_path($data->image);
        }
        if ($data->delete()) {
            if ($preImage) {
                    if(file_exists($existsImage) && $preImage){
                        unlink($existsImage);
                    }
                }
            return redirect()->back()->with('success', 'User removed successfully.');
        }else{
            return redirect()->back()->with('failed', 'Failed ! wrong input.');
        }
        //return view('admin/user/prifile',compact('data'));

    }

     public function statusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:1,2']);
       $data=User::where('email',$slug)->first();
        if($data){
            $data->status=$request->status;
            $data->save();
            return redirect()->route('admin.companies')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }

    public function add($value='')
    {
        return view('admin/company/add');
    }

    public function edit($slug)
    {
        $data=User::select('id','name','email','status')->where('email',$slug)->first();
        if($data){
            return view('admin/company/edit',compact('data'));
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
        
    }

    public function insert(Request $request)
    {
        $time=time();
        $file='upload/user/';
        $request->validate(['username'=>'required|unique:users,email','password'=>'required|min:6','confirm_password'=>'required|same:password']);
        
        if($request->image){
            $request->validate(['image'=>'mimes:jpeg,png,jpg,gif,svg|max:2048']);
        }
        $data=new User;
        $data->name=$request->username;
        $data->email=$request->username;
        $data->original_password=$request->password;
        $data->password=Hash::make($request->password);
        //$data->slug=Str::slug($request->name, '-');
        if($request->image){
            $imageName=$time.'.'.$request->image->extension();
            $data->image=$file.$imageName;
        }
        if($data->save()){
            $data->company_key=$this->companykey.$data->id;
            $data->save();
            if($request->image){
              $request->image->move(public_path($file),$imageName);
            }
            return redirect()->route('admin.companies')->with('success', 'Saved successfully !');
        }else{
            return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }
    public function update(Request $request,$slug)
    {
        $time=time();
        $data=User::where('email',$slug)->first();
        $old='';
        if (isset($data->image)) {
             $old=$data->image;
        }       
        $request->validate(['username'=>'required|unique:users,email,'.$data->id]);
        if($request->image){
            $request->validate(['image'=>'mimes:jpeg,png,jpg,gif,svg|max:2048']);
        }
        if($data){
            $pre_img=public_path($data->image);
            $file='upload/user/';
            $data->email=$request->username;
            //$data->slug=Str::slug($request->name, '-');
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
                
                return redirect()->route('admin.companies')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }

    public function passwordSave(Request $request)
    {
       $request->validate(['current_password'=>'required','new_password'=>'required|min:6|different:current_password','confirm_password'=>'required|same:new_password']);
       if (Hash::check($request->current_password, Auth::user()->password)) 
       { 
            $user=User::where(['id'=>Auth::user()->id])->first();
           $user->fill([
            'password' => Hash::make($request->new_password)
            ])->save();

            return redirect()->route('admin.companies')->with('success', 'Password changed Successfully');

        } else {

            return redirect()->back()->with('failed','Sorry ! Old Password does not match');
        }

    }

    public function trashed($name='')
    {
        extract($_GET);
        $data=User::onlyTrashed()->orderBy('name','asc')->where(['is_admin'=>'2']);
        if (isset($name) && $name) {
            $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data = $data->paginate($this->paginate);
        $page = ($data->perPage()*($data->currentPage() -1 ));
        return view('admin/company/trashed',compact('data','name','page','total'));
    }

    
    public function restore($slug)
    {
        $data=User::withTrashed()->where('email',$slug)->restore();
        
        if($data){
            return redirect()->route('admin.companies')->with('success', 'Restore successfully !');
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }
    public function removeTrashed($slug)
    {
        $data=User::withTrashed()->where('email',$slug)->first();
        $pre_img=public_path($data->image);
        $file='upload/category/';
        if($data->forceDelete()){
            return redirect()->route('admin.companies')->with('success', 'Permanent removed successfully !');
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }

     public function documentStatusChange(Request $request,$slug)
    {
        $request->validate(['status'=>'required|numeric|in:4']);
       $data=User::where('email',$slug)->first();
        if($data){
            $data->company_approved=$request->status;
            $data->save();
            return redirect()->route('admin.companies')->with('success', 'Status changed successfully !');
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }
    }

    public function view($slug)
    { 
       $data=User::where('email',$slug)->first();
        if($data){
            return view('admin/company/view',compact('data'));
        }else{
           return redirect()->route('admin.companies')->with('error', 'Failed ! try again.');
        }

    }

}
