<?php

namespace App\Imports;

use App\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Auth;
class VendorImport implements ToModel, WithStartRow,WithHeadingRow,WithValidation,SkipsOnFailure
{
	use Importable,SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function startRow():int
    {
    	return 2;
    }

    public function model(array $row)
    {
    	$state=\App\State::select('id','name','slug')->where('name',$row['state'])->first();
    	$state_id=$state->id;
        $state_ary=json_encode($state);
        $city=\App\City::select('id','name','slug')->where('name',$row['city'])->first();
    	$city_id=$city->id;
        $city_ary=json_encode($city);

        $vendor = new Vendor;
            $vendor->name     = $row['name'];
            $vendor->email    = $row['email'];
            $vendor->original_password    = $row['password']; 
            $vendor->password = Hash::make($row['password']);
            $vendor->phone    = $row['phone'];
            $vendor->state_id    =$state_id;
            $vendor->state_ary    =$state_ary;
            $vendor->city_id    = $city_id; 
            $vendor->city_ary    = $city;
            $vendor->bank_account_type    = $row['bank_account_type'];
            $vendor->bank_account_number    = $row['account_number'];
            $vendor->ifsc    = $row['ifsc'];
            $vendor->pan   = $row['pan'];
            //'specified_person'    => $row['specified_person'],
            $vendor->address    = $row['address'];
            $vendor->location    = $row['location'];
            $vendor->zip    = $row['zip'];
            $vendor->constitution    = $row['constitution'];
            $vendor->specify_if_other    = $row['specify_if_other'];
            $vendor->gst   = $row['gst'];
            $vendor->user_id    = Auth::guard('employee')->user()->id;
            $vendor->user_ary= json_encode(\App\Employee::where('id',Auth::guard('employee')->user()->id)->select('id','name','email','mobile','employee_code')->first());
        if ($vendor->save()) {
            $vendor->vendor_code=\App\Helpers\Helper::vendorUniqueNo($vendor->id);
            $vendor->save();
        }
        return $vendor;

    }

    public function rules(): array
    {

        $valid='';
        return [
                'name'=>'required',
                'email'=>'required|email|unique:vendors,email',
                'password'=>'required|min:6',
                'phone'=>'required|numeric|digits:10',
                'state'=>'required|exists:states,name',
                'city'=>'required|exists:cities,name',
                'bank_account_type'=>'required|in:Saving,Current',
                'account_number'=>'required',
                'ifsc'=>'required',
                'pan'=>'required|max:10|min:10|unique:vendors,pan',
                //'specified_person'=>'',
                'address'=>'required',
                'location'=>'required',
                'specify_if_other'=>'',
                'gst'=>'',
                'constitution'=>'required|in:Sole Propritor,Partnership,Company,Trust,AOP,Others',
                'specify_if_other'=>$valid
        ];
    }
}

           