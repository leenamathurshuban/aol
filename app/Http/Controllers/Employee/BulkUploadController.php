<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\BulkUploadRequest;
use App\Helpers\Helper;
use App\BulkUpload;
use App\BulkUploadFile;
use App\Employee;
use App\Setting;
use App\BulkCsvUpload;
use Auth;
use App\Apex;
use PDF;
use App\Imports\BulkImportCheckErrorImport;
use App\Exports\BulkUploadExport;
use App\Imports\BulkCsvUploadImport;
use Carbon\Carbon;
class BulkUploadController extends Controller
{
    function __construct($foo = null)
    { 
    	$this->paginate = 10;
        $this->path='BulkUpload/';
        $this->csvPath='BulkUploadCSV/';
        $this->time = time().rand(111111,999999);
        $this->date=Helper::importDateInFormat();
    }

    public function index($request_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5) && ($roleId==4 || $roleId==9 || $roleId==5 || $roleId==7 || $roleId==10 || $roleId==11))
        {
            extract($_GET);
            $data=BulkUpload::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst);
            }
            if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
            $data->where('status', 6);
           // $data->where('status', '7');
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/BulkUpload/approvedList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function add($value='')
    { 
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,5) && $roleId==4) {
        	return view('employee/BulkUpload/add',compact('apexes'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function insert(BulkUploadRequest $request)
    {
        $path = $this->path;
        $time = $this->time;
        $csvPath =$this->csvPath;
        /*--------*/
        $file = new BulkImportCheckErrorImport($request->payment_type);
        $file->import(request()->file('bulk_attachment_file'));
        foreach ($file->failures() as $failure) {
                $failure->row(); 
                $failure->attribute(); 
                $failure->errors(); 
                $failure->values();
                if (BulkCsvUpload::where('refrence',$failure->values()['refrence'])->whereDate('created_at', Carbon::today())->count()) {
                    return redirect()->back()->with('failed',' Reference ID should be unique for the day, cannot duplicate ID already used earlier');
                }
                if($failure->errors() && !empty($failure->errors())) {
                    return redirect()->back()->with('sheeterror', $failure);
                }
            }
            /*--------*/
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5) && $roleId==4) {
            $data = new BulkUpload;
            $data->category = $request->category;
            $data->specify_detail = $request->specify_detail;
            $data->bank_formate = $request->bank_formate;
            $data->payment_type = $request->payment_type;
            $data->description = $request->description;

            $data->employee_id = Auth::guard('employee')->user()->id;
            $data->employee_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
            $data->employee_date=$this->date;
            if($request->bulk_attachment_file){
                $csvName=$time.'.'.$request->bulk_attachment_file->extension();
                $data->bulk_attachment_path=$csvPath.$csvName;
                $data->bulk_attachment_type = $request->bulk_attachment_file->extension();
            }
            $data->bulk_attachment_description = $request->bulk_attachment_description;
            $data->apexe_id = $request->apex;
            $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
            if($data->save()){
                    $data->order_id=Helper::BulkUploadUniqueNo($data->id);
                    $data->save();
                    if($request->bulk_attachment_file){
                        $file1 = new BulkCsvUploadImport($data->payment_type,$data->id);
                        $file1->import(request()->file('bulk_attachment_file'));
                        foreach ($file1->failures() as $failure1) {
                                $failure1->row(); 
                                $failure1->attribute(); 
                                $failure1->errors(); 
                                $failure1->values();
                                if($failure1->errors() && !empty($failure1->errors())) {
                                    return redirect()->back()->with('success', 'Data imported Successfully')->with('sheeterror', $failure1);
                                }
                            }
                         $request->bulk_attachment_file->move(public_path($csvPath),$csvName);
                    }
                    if ($request->supporting_file) {
                        foreach ($request->supporting_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new BulkUploadFile;
                                $reqImg->bulk_upload_id  = $data->id;
                                $reqImg->bulk_upload_file_path = $path.$imgName;
                                $reqImg->bulk_upload_file_type = $img->extension();
                                $reqImg->bulk_upload_file_description = $request->supporting_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                    return redirect()->route('employee.pendingBulkUpload')->with('success', 'Saved successfully !');
                }else{
                    return redirect()->back()->with('failed', 'Failed ! try again.');
                }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function pendingRequest($request_number='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5) && ($roleId==4 || $roleId==9 || $roleId==5 || $roleId==7 || $roleId==10 || $roleId==11))
        {
            extract($_GET);
            $data=BulkUpload::orderBy('id','DESC');
            if ($roleId==5) {
                $aplst=[$empId];
                $emplst = \App\Employee::select('id')->where('approver_manager',$empId)->where('id','!=',$empId)->get();
                foreach ($emplst as $emplstkey => $emplstvalue) {
                    $aplst[]=$emplstvalue->id;
                }
                $data->whereIn('employee_id',$aplst);
            }
            if(isset($request_number) && !empty($request_number)){
                 $data->where('order_id', $request_number);
            }
             if ($roleId==4) {
                 $data->where('employee_id',$empId);
             }
             
            $data->whereNotIn('status', [2,6]);
            $total=$data->count();
            $data=$data->paginate($this->paginate);
            $page = ($data->perPage()*($data->currentPage() -1 ));
            $currentPage=$data->currentPage();
               return view('employee/BulkUpload/pendingList',compact('data','request_number','page','total','currentPage'));
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function remove($slug)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5) &&  ($roleId==4)) {
            $data=BulkUpload::where('order_id',$slug)->whereNotIn('status',[3,4,5,6,7]);
            $path = $this->path;
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                $id=$data->id;
                if ($data->bulkReqImage) {
                   foreach ($data->bulkReqImage as $key => $ImgData) {
                    $pre_img=public_path($ImgData->bulk_upload_file_path);
                      if(file_exists($pre_img) && $ImgData->bulk_upload_file_path){
                            unlink($pre_img);
                        }  
                    }
                }
                $csv_img=public_path($data->bulk_attachment_path);
                $old=$data->bulk_attachment_path;
                if(file_exists($csv_img) && $old){
                            unlink($csv_img);
                        }
                $data->delete();
                return redirect()->back()->with('success', 'Removed successfully !');
            }else{
               return redirect()->back()->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function editPending($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        $apexes=Apex::apxWidIdPluck();
        if (\App\Employee::chkProccess($empId,5) &&  ($roleId==4)) {
            $data=BulkUpload::where('order_id',$slug)->whereNotIn('status',[2,3,4,5,6,7]);
            if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
            if($data){
                return view('employee/BulkUpload/editPending',compact('data','page','apexes'));
            }else{
               return redirect()->route('employee.pendingBulkUpload')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    
    public function updatePending(BulkUploadRequest $request,$slug=null,$page=null)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5) && ($roleId==4)) {
            $path = $this->path;
            $time = $this->time;
            $csvPath =$this->csvPath;
             $data=BulkUpload::where('order_id',$slug)->whereNotIn('status',[2,3,4,5,6,7]);
             if ($roleId==4 || $roleId==5) {
                 $data->where('employee_id', $empId);
            }
            $data=$data->first();
             if ($data) {
                $data->category = $request->category;
                $data->specify_detail = $request->specify_detail;
                $data->bank_formate = $request->bank_formate;
                $data->payment_type = $request->payment_type;
                $data->description = $request->description;

                $data->employee_id = Auth::guard('employee')->user()->id;
                $data->employee_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                $data->employee_date=$this->date;
                $pre_img=public_path($data->bulk_attachment_path);
                if($request->bulk_attachment_file){
                    $old=$data->bulk_attachment_path;
                    $csvName=$time.'.'.$request->bulk_attachment_file->extension();
                    $data->bulk_attachment_path=$csvPath.$csvName;
                    $data->bulk_attachment_type = $request->bulk_attachment_file->extension();
                }
                $data->bulk_attachment_description = $request->bulk_attachment_description;
                $data->apexe_id = $request->apex;
                $data->apexe_ary = json_encode(Apex::where('id',$request->apex)->select('id','name','slug')->first());
                if($data->save()){
                    if($request->bulk_attachment_file){
                        if(file_exists($pre_img) && $old){
                            unlink($pre_img);
                        }
                      $request->bulk_attachment_file->move(public_path($csvPath),$csvName);
                    }
                    if ($request->supporting_file) {
                        foreach ($request->supporting_file as $key => $img) {
                            if($img){
                                $imgName=($time.$key.$data->id).'.'.$img->extension();
                                $reqImg=new BulkUploadFile;
                                $reqImg->bulk_upload_id  = $data->id;
                                $reqImg->bulk_upload_file_path = $path.$imgName;
                                $reqImg->bulk_upload_file_type = $img->extension();
                                $reqImg->bulk_upload_file_description = $request->supporting_file_description[$key];
                                if ($reqImg->save()) {
                                    $img->move(public_path($path),$imgName);
                                }
                            }
                        }
                    }
                        return redirect()->route('employee.pendingBulkUpload',($page > 1) ? 'page='.$page : '')->with('success', 'Updated successfully !');
                    }else{
                        return redirect()->back()->with('failed', 'Failed ! try again.');
                }

             }else{
               return redirect()->back()->with('failed', 'Invalid ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function statusApprove($slug,$page)
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
       
        if (\App\Employee::chkProccess($empId,5) &&  ($roleId!=4 || $roleId!=11)) {
            $data=BulkUpload::where('order_id',$slug)->whereIn('status',[1,3,4,5,6,7]);
            if ($roleId==5) {
                 $data->where('status', 1);
            }
            if ($roleId==9) {
                 $data->where('status', '3');
            }
            if ($roleId==7) {
                 $data->where('status', '4');
            }
            if ($roleId==10) {
                 $data->where('status', '5');
            }
            if ($roleId==11) {
                 $data->where('status', '6');
            } 
            $data=$data->first();
            if($data){
                return view('employee/BulkUpload/statusApprove',compact('data','page'));
            }else{
               return redirect()->route('employee.pendingBulkUpload',($page > 1) ? 'page='.$page : '')->with('failed', 'Failed ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }
    //emp=4,mang=5,acc=9,trust=7,payofc=10,tds=11
    public function statusRequestApprove(Request $request,$slug=null,$page=null)
    {
        $path = $this->path;
        $time = $this->time;
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,5)  && ($roleId!=4 || $roleId!=11)) {
            $comt='';
            if ($request->status==2) {
                $comt='required';
            }
            if ($roleId==5) {
               $request->validate(['status'=>'required|in:2,3','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==7) {
                $request->validate(['status'=>'required|in:2,5','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==9) {

                $request->validate(['status'=>'required|in:2,4','comment'=>$comt,'specified_person'=>'required|in:Yes,No',
                    'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==10) {
                $request->validate(['status'=>'required|in:2,6','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            if ($roleId==11) {
                $request->validate(['status'=>'required|in:2,7','comment'=>$comt,
            'emp_req_file[]'=>'mimes:jpeg,png,jpg,gif,svg,doc,csv,xlsx,xls,docx,ppt,pdf|max:2048']);
            }
            $data=BulkUpload::where('order_id',$slug)->whereIn('status',[1,3,4,5,6]);
            if ($roleId==5) {
                 $data->where('status', '1');
            }
            if ($roleId==9) {
                 $data->where('status', '3');
            }
            if ($roleId==7) {
                 $data->where('status', '4');
            }
            if ($roleId==10) {
                 $data->where('status', '5');
            }
            if ($roleId==11) {
                 $data->where('status', '6');
            }
            $data=$data->first();
            if ($data) {
                if ($roleId==5) {
                   $data->status = $request->status;
                   $data->manager_id = Auth::guard('employee')->user()->id;
                   $data->manager_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->manager_comment = $request->comment;
                   $data->manager_date=$this->date;
                   
                }
                if ($roleId==7) {
                   $data->status = $request->status;
                   $data->trust_ofc_id = Auth::guard('employee')->user()->id;
                   $data->trust_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->trust_ofc_comment = $request->comment;
                   $data->trust_date=$this->date;
                }
                if ($roleId==9) {
                   $data->status = $request->status;
                   $data->account_dept_id = Auth::guard('employee')->user()->id;
                   $data->account_dept_ary =json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->account_dept_comment = $request->comment;
                   $data->specified_person = $request->specified_person;
                   $data->accountant_date=$this->date;
                   if ($request->debit_account) {
                            foreach ($request->debit_account as $f_key => $f_value) {
                                 $formAccount[] = ['debit_account'=>$f_value,'amount'=>$request->amount[$f_key],'cost_center'=>$request->cost_center[$f_key],'category'=>$request->category[$f_key]];
                            }
                         $data->form_by_account=json_encode(['form_by_account'=>$formAccount,'bank_account'=>$request->bank_account[$data->id],'ifsc'=>$request->ifsc[$data->id],'bank_name'=>$request->bank_name[$data->id]]);
                    }
                }
                if ($roleId==10) {
                   $data->status = $request->status;
                   $data->payment_ofc_id = Auth::guard('employee')->user()->id;
                   $data->payment_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->payment_ofc_comment = $request->comment;
                   $data->payment_date=$this->date;
                }
                if ($roleId==11) {
                   $data->status = $request->status;
                   $data->tds_ofc_id = Auth::guard('employee')->user()->id;
                   $data->tds_ofc_ary = json_encode(Employee::employeeAry(Auth::guard('employee')->user()->id));
                   $data->tds_ofc_comment = $request->comment;
                   $data->tds_date=$this->date;
                }
                if($data->save()){
                    return redirect()->route('employee.pendingBulkUpload')->with('success', 'Approval status changed successfully !');
                }else{
                    return redirect()->back()->with('failed', 'Failed ! try again.');
                }

            }else{
                    return redirect()->back()->with('failed', 'Invalid Request ! try again.');
            }
        }else{
                return redirect()->route('employee.home')->with('failed', 'Failed ! try again.');
        }
    }

    public function BulkUploadDetail(Request $request)
    {
        $data=BulkUpload::where('order_id',$request->slug)->first();
        if($data){
            $type='BulkUploadDetail';
            return view('employee/BulkUpload/ajax',compact('data','type'));
        }else{
           return '<h2>Data not found.</h2>';
        }
    }

    public function removePendingReqImage($id)
    {
       $data=BulkUploadFile::where('id',$id)->first();
       $pre_img=public_path($data->bulk_upload_file_path);
      if ($data->delete()) {
           if(file_exists($pre_img) && $data->bulk_upload_file_path){
                unlink(public_path($data->bulk_upload_file_path));
            }
            return redirect()->back()->with('success','Image removed successfully');
       }else{
          return redirect()->back()->with('error', 'Failed ! try again.');
       }
    }

    public function bulkUploadPDF($value='')
    {
        $data['data']=BulkUpload::where('order_id',$value)->first();
        if ($data) {
            $pdf = PDF::loadView('employee/BulkUpload/bulkUploadPDF', $data);
            return $pdf->download('bulk-upload-'.date('d-m-Y').'.pdf');
        }else{
            return redirect()->back()->with('error', 'Failed ! try again.');
        }
    }

    public function bulkExport($slug='')
    {
        $empId = Auth::guard('employee')->user()->id;
        $roleId = Auth::guard('employee')->user()->role_id;
        if (\App\Employee::chkProccess($empId,3) && $roleId==4) {
            return Excel::download(new BulkUploadExport($slug), 'bulkImplode.xlsx');
        }else{
                return redirect()->route('employee.home')->with('error', 'Failed ! try again.');
        }
        //employee.bulkUploadExport
    }
}
