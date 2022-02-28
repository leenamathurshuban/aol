<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\DebitAccountRequest;
use App\DebitAccount;
class DebitAccountController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=DebitAccount::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('name', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id','name','slug','status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/DebitAccount/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
    	return view('admin/DebitAccount/add');
    }
    public function edit($slug)
    {
    	$data=DebitAccount::select('id','name','slug')->where('slug',$slug)->first();
        if($data){
            return view('admin/DebitAccount/edit',compact('data'));
        }else{
           return redirect()->route('admin.debit_accounts')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(DebitAccountRequest $request,$slug=null)
    {
    	$data=new DebitAccount;
    	$data->name=$request->debit_account_number;
        $data->slug=Str::slug($request->debit_account_number, '-');
    	if($data->save()){
    		return redirect()->route('admin.debit_accounts')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.debit_accounts')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(DebitAccountRequest $request,$slug=null)
    {
        $time=time();
        $data=DebitAccount::where('slug',$slug)->first();  
        if($data){
            $data->name=$request->debit_account_number;
            $data->slug=Str::slug($request->debit_account_number, '-');
            if($data->save()){
                return redirect()->route('admin.debit_accounts')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.debit_accounts')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.debit_accounts')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=DebitAccount::where('slug',$slug)->first();
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
        $data=DebitAccount::where('slug',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.debit_accounts')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.debit_accounts')->with('error', 'Failed ! try again.');
        }
    }
}
