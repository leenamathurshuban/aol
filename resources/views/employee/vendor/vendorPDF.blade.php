@php $inr = Html::decode('<img src="'.url('assets/admin/inr-dark.png').'" style="height: 11px;">');@endphp
<table style="width: 100%; text-align: left !important; border-collapse: collapse; border: solid 1px #ccc;font-size: 13px;line-height: 16px" cellpadding="5" cellspacing="0">
  <tr style="width: 100%">
    <td colspan="3" style="text-align: center;"><strong>{{ $data->name.' '.$data->vendor_code ?? 'Vendor Detail' }}</strong></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Name:</strong><p>{{ $data->name ?? '' }}</p></td>
    @if(Auth::guard('employee')->user()->role_id==8)
    <td style="border: solid 1px #ccc;"><strong>Email:</strong><p>{{ $data->email ?? '' }}</td>
    <td style="border: solid 1px #ccc;"><strong>Password:</strong><p>{{ $data->original_password ?? '' }}</p></td>
    @else
    <td style="border: solid 1px #ccc;"></td>
    <td style="border: solid 1px #ccc;"></td>
    @endif
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Contact:</strong> <p>{{ $data->phone ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Form Type:</strong><p>{{ \App\Vendor::requestType($data->vendor_type) }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Added By Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p></td>
  </tr>
  @if($data->approved_user_id)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Approver Name:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Approver Code:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Approver Mobile:</strong><p> {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"></td>
  </tr>
  @endif
   
   <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Bank Account Type:</strong><p>{{ $data->bank_account_type ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank Account:</strong><p>{{ $data->bank_account_number ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Bank IFSC:</strong><p>{{ $data->ifsc ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Pan Number:</strong><p>{{ $data->pan ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>State:</strong> <p>{{ json_decode($data->state_ary)->name ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>City:</strong><p>{{ json_decode($data->city_ary)->name ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Address:</strong><p>{{ $data->address ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Location:</strong><p>{{ $data->location ?? '' }}</p></td>
  </tr>
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Zip:</strong><p>{{ $data->zip ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>Constitution:</strong><p>{{ $data->constitution ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"><strong>GST:</strong><p>{{ $data->gst ?? '' }}</p></td>
  </tr>
  @if($data->account_status)
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Status:</strong> </td>
    <td style="border: solid 1px #ccc;"><p class="{{ ($data->account_status==3) ? 'btn btn-success' : 'btn btn-danger'}}">{{ \App\Vendor::accountStatus($data->account_status) }}</p></td>
    <td style="border: solid 1px #ccc;"></td>
  </tr>
  @endif
  <tr style="width: 100%">
    <td style="border: solid 1px #ccc;"><strong>Specify If Constitution Others:</strong></td>
    <td style="border: solid 1px #ccc;"><p>{{ $data->specify_if_other ?? '' }}</p></td>
    <td style="border: solid 1px #ccc;"></td>
  </tr>
  <tr style="width: 100%">
    @if($data->pan_file)
    <td style="border: solid 1px #ccc;"><p><strong>Pan Image</strong></p></td>
    
    <td style="border: solid 1px #ccc;">
        <img src="{{ url('public/'.$data->pan_file) }}" alt="user" style="max-width: 150px;max-height: 150px" />
      
    </td>
    @endif
    @if($data->cancel_cheque_file)
    <td style="border: solid 1px #ccc;">
       <p><strong>Cancel Cheque</strong></p>
        <img src="{{ url('public/'.$data->cancel_cheque_file) }}" alt="user" style="max-width: 150px;max-height: 150px"/>
    </td>
    @endif
  </tr>
</table>