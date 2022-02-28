<?php

namespace App\Helpers;
use Request;
use Str;
use Carbon\Carbon;
use Auth;
use Form;
class Helper 
{
	
	public static function classActiveByRouteName($routeName) {
		$curRoute=\Request::route()->getName(); 
		$class='';
		foreach($routeName as $route) {
			if ($curRoute==$route) {
				$class = 'active';
			}
		}
		return $class;
	}

	public static function classMenuOpenByRouteName($routeName) {
		$curRoute=\Request::route()->getName(); 
		$class='';
		foreach($routeName as $route) {
			if ($curRoute==$route) {
				$class = 'menu-is-opening menu-open';
			}
		}
		return $class;
	}

	public static function poUniqueNo($value='')
	{
		
		$count=strlen($value);
		$num='';
		
		return 'PO'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}
	public static function getDate($datetime=null, $format=null) {
		$format = $format ? $format:'Y-m-d H:i:s';
		$datetime = $datetime ? $datetime:Carbon::now();
		return Carbon::createFromFormat('Y-m-d', $datetime)->format($format);
	}
	public static function getDateTime($datetime=null, $format=null) {
		$format = $format ? $format:'Y-m-d H:i:s';
		$datetime = $datetime ? $datetime:Carbon::now();
		return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->format($format);
	} 

	public static function chkImage($value='')
	{
		if ($value) {
			return url('/public/'.$value);
		}else{
			return '';
		}
	}

	public static function defaultImage($value='')
	{
		if ($value) {
			return url('/public/'.$value);
		}else{
			return url('assets/admin/dist/img/not-found.png');
		}
	}

	public static function bankAccountType($value='')
	{
		$data=['Saving'=>'Saving','Current'=>'Current'];
		if ($value) {
			return $data[$value];
		}else{
			return $data;
		}
	}

	public static function getDocType($file_url, $ext=null) {
    	$doctype = '';
	    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'svg') {
	      $doctype = "<img src='".url('public/'.$file_url)."' width='70' height='70' />";
	    } else if($ext == 'doc' || $ext == 'docx') {
	      $doctype = "<img src='".url('public/images/doc.png')."' width='70' height='70' />";
	    } else if($ext == 'xls' || $ext == 'xlsx') {
	      $doctype = "<img src='".url('public/images/excel.png')."' width='70' height='70' />";
	    } else if($ext == 'csv') {
	      $doctype = "<img src='".url('public/images/csv.png')."' width='70' height='70' />";
	    } else if($ext == 'ppt' || $ext == 'pptx') {
	      $doctype = "<img src='".url('public/images/ppoint.png')."' width='70' height='70' />";
	    } else if($ext == 'pdf') {
	      $doctype = "<img src='".url('public/images/pdf.png')."' width='70' height='70' />";
	    } else if($ext == 'zip') {
	      $doctype = "<img src='".url('public/images/zip.png')."' width='70' height='70' />";
	    } else {
	      $doctype = "<img src='".url('public/images/file.png')."' width='70' height='70' />";
	    }
    	return $doctype;
  	}

  	public static function vendorUniqueNo($value='')
	{
		
		$count=strlen($value);
		$num='';
		return 'V'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function onlyDate($value='',$format=null)
	{
		$d_format='d M Y';
		if ($format) {
			$d_format=$format;
		}
		return date($d_format,strtotime($value));
	}

	public static function employeePayUniqueNo($value='')
	{
		
		$count=strlen($value);
		$num='';
		return 'EP'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function internalTransferUniqueNo($value='')
	{
		
		$count=strlen($value);
		$num='';
		return 'ST'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function BulkUploadUniqueNo($value='')
	{
		
		$count=strlen($value);
		$num='';
		return 'BU'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function invoiceUniqueNo($value='')
	{
		//$value = (\App\PurchaseOrder::orderBy('id','desc')->latest()->first()->id ?? '0')+1;
		$count=strlen($value);
		$num='';
		/*for ($i=$count; $i < 6; $i++) { 
			$num=$num.'0';
		}*/
		//return 'DG'.$num.$value;
		//return 'A'.	str_pad($value, 6, '0', STR_PAD_LEFT);
		return 'POIN'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function withoutpoInvoiceUniqueNo($value='')
	{
		$count=strlen($value);
		$num='';
		return 'WDIN'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function debitAccount($value='',$id='')
	{
		if ($id) {
			return Form::select('debit_account['.$id.'][]',\App\DebitAccount::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Debit account','required'=>'true']); 
		}else{
			return Form::select('debit_account[]',\App\DebitAccount::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Debit account','required'=>'true']); 
		}
	}
	public static function costCenter($value='',$id='')
	{
		if ($id) {
			return Form::select('cost_center['.$id.'][]',\App\CostCenter::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Cost Center','required'=>'true']); 
		}else{
			return Form::select('cost_center[]',\App\CostCenter::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Cost Center','required'=>'true']);
		}
	}
	public static function category($value='',$id='')
	{
		if ($id) {
			return Form::select('category['.$id.'][]',\App\Category::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Category','required'=>'true']); 
		}else{
			return Form::select('category[]',\App\Category::pluck('name','name'),$value,['class'=>'form-control custom-select select2','placeholder'=>'Select Category','required'=>'true']); 
		}
	}

	public static function reportType($value='')
	{
		$data=['po'=>'Purchase Order','inv'=>'PO Invoices','wdinv'=>'Without PO Invoices','bnkRtrn'=>'Internal Transfer','empPay'=>'Employee Pay','bulkUp'=>'Bulk Upload'];
		if ($value) {
			return $data[$value];
		}else{
			return $data;
		}
	}

	public static function bulkUploadvCsvUniqueNo($value='')
	{
		$count=strlen($value);
		$num='';
		return 'U'.	date('d').date('m').date('y').'-'.str_pad($value, 2, '0', STR_PAD_LEFT);
	}

	public static function importDateInFormat($value='')
	{
		if ($value) {
			return date('Y-m-d',strtotime(str_replace('/', '-', $value)));
		}else{
			return date('Y-m-d');
		}
	}
}