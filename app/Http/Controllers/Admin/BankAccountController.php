<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Http\Requests\BankAccountRequest;
use App\BankAccount;
use App\Apex;

class BankAccountController extends Controller
{
    function __construct($foo = null)
    { 
        $this->paginate = 10;
    }
    public function index($name='')
    {
        extract($_GET);
        $data=BankAccount::orderBy('id','DESC');
        if(isset($name) && !empty($name)){
             $data->where('bank_account_number', 'LIKE', "%$name%")->orWhere('bank_name', 'LIKE', "%$name%")->orWhere('branch_address', 'LIKE', "%$name%")->orWhere('branch_code', 'LIKE', "%$name%")->orWhere('ifsc', 'LIKE', "%$name%");
        }
        $total=$data->count();
        $data=$data->select('id', 'bank_name', 'bank_account_number', 'branch_address', 'branch_code', 'bank_account_holder', 'ifsc', 'slug', 'status')->paginate($this->paginate);
    	$page = ($data->perPage()*($data->currentPage() -1 ));
    	return view('admin/bank_account/list',compact('data','name','page','total'));

    }

    public function add($value='')
    {
        $apexes=Apex::pluck('name','slug');
    	return view('admin/bank_account/add',compact('apexes'));
    }
    public function edit($slug)
    {
        $apexes=Apex::pluck('name','slug');
    	$data=BankAccount::select('id', 'bank_name', 'bank_account_number', 'branch_address', 'branch_code', 'bank_account_holder', 'ifsc', 'slug', 'status','apexe_id')->where('slug',$slug)->first();
        if($data){
            return view('admin/bank_account/edit',compact('data','apexes'));
        }else{
           return redirect()->route('admin.bankAccounts')->with('error', 'Failed ! try again.');
        }
    	
    }

    public function insert(BankAccountRequest $request,$slug=null)
    {
    	$data=new BankAccount;
        $apexAry=Apex::where('slug',$request->apex)->select('id','name','slug')->first();
        $data->apexe_id = $apexAry->id;
        $data->apexe_ary = json_encode($apexAry);
    	$data->bank_name=$request->bank_name;
    	$data->bank_account_number=$request->bank_account_number;
    	$data->branch_address=$request->branch_address;
    	$data->branch_code=$request->branch_code;
    	$data->bank_account_holder=$request->bank_account_holder;
    	$data->ifsc=$request->ifsc;
        $data->slug=Str::slug($request->bank_account_number, '-');
    	if($data->save()){
    		return redirect()->route('admin.bankAccounts')->with('success', 'Saved successfully !');
    	}else{
    		return redirect()->route('admin.bankAccounts')->with('error', 'Failed ! try again.');
    	}
    }
    public function update(BankAccountRequest $request,$slug=null)
    {
        $time=time();
        $data=BankAccount::where('slug',$slug)->first();  
        if($data){
            $apexAry=Apex::where('slug',$request->apex)->select('id','name','slug')->first();
            $data->apexe_id = $apexAry->id;
            $data->apexe_ary = json_encode($apexAry);
            $data->bank_name=$request->bank_name;
	    	$data->bank_account_number=$request->bank_account_number;
	    	$data->branch_address=$request->branch_address;
	    	$data->branch_code=$request->branch_code;
	    	$data->bank_account_holder=$request->bank_account_holder;
	    	$data->ifsc=$request->ifsc;
            $data->slug=Str::slug($request->bank_account_number, '-');
            if($data->save()){
                return redirect()->route('admin.bankAccounts')->with('success', 'Saved successfully !');
            }else{
                return redirect()->route('admin.bankAccounts')->with('error', 'Failed ! try again.');
            }
        }else{
           return redirect()->route('admin.bankAccounts')->with('error', 'Failed ! try again.');
        }
    }

    public function statusChange(Request $request,$slug)
    {
    	$request->validate(['status'=>'required|numeric|in:1,2']);
       $data=BankAccount::where('slug',$slug)->first();
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
        $data=BankAccount::where('slug',$slug)->first();
        if($data->delete()){
            return redirect()->route('admin.bankAccounts')->with('success', 'Removed successfully !');
        }else{
           return redirect()->route('admin.bankAccounts')->with('error', 'Failed ! try again.');
        }
    }
}
