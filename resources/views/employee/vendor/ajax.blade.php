@if($type=='getVendorFormCityByState')

{{ Form::label('City',$states->name."'s city") }}
  {!!Form::select('city', $cities, '', ['placeholder' => 'Select City','class'=>'form-control custom-select select2','id'=>''])!!}

@elseif($type=='getCityByState')

  {{ Form::label('City',$states->name."'s city") }}
  {!!Form::select('city', $cities, '', ['placeholder' => 'Select City','class'=>'form-control custom-select select2','id'=>''])!!}



  @elseif($type=='viewDetail')
                    <div class="row">
                        <div class="col-md-12 model_title"><h3>{{ $data->name.' '.$data->vendor_code ?? 'Vendor Detail' }} </h3>
                         </div>
                         <div class="col-md-12 vander_dataview">
                            <ul>
                              <li><strong>Name:</strong><p>{{ $data->name ?? '' }}</p></li>
                              @if(Auth::guard('employee')->user()->role_id==8)
                              <li><strong>Email:</strong><p>{{ $data->email ?? '' }}</p></li>
                              <li><strong>Password:</strong><p>{{ $data->original_password ?? '' }}</p></li>
                              @endif
                              <li><strong>Contact:</strong> <p>{{ $data->phone ?? '' }}</p></li>
                              
                              <li><strong>Form Type:</strong><p>{{ \App\Vendor::requestType($data->vendor_type) }}</p></li>
                            <li>
                              <strong>Added By Name:</strong><p>{{ json_decode($data->user_ary)->name ?? '' }}</p>
                            </li>
                             <li>
                              <strong>Code:</strong><p>{{ json_decode($data->user_ary)->employee_code ?? '' }}</p>
                            </li>


                            @if($data->approved_user_id)

                            <li>
                              <strong>Approver Name:</strong><p>{{ json_decode($data->approved_user_ary)->name ?? '' }}</p>
                            </li>

                             <li>
                              <strong>Code:</strong><p>{{ json_decode($data->approved_user_ary)->employee_code ?? '' }}</p>
                            </li>

                             <li>
                              <strong>Approver Mobile:</strong><p>{{ json_decode($data->approved_user_ary)->mobile_code ?? '' }} {{ json_decode($data->approved_user_ary)->mobile ?? '' }}</p>
                            </li>
                            @endif

                         
                            <li>
                              <strong>Bank Account Type:</strong><p>{{ $data->bank_account_type ?? '' }}</p>
                            </li>
                         

                            <li>
                              <strong>Bank Account:</strong><p>{{ $data->bank_account_number ?? '' }}</p>
                            </li>

                            <li>
                              <strong>Bank IFSC:</strong><p>{{ $data->ifsc ?? '' }}</p>
                            </li>


                            <li>
                              <strong>Pan Number:</strong><p>{{ $data->pan ?? '' }}</p>
                            </li>

                          
                            <li>
                              <strong>Specified Person:</strong><p>{{ $data->specified_person ?? '' }}</p>
                            </li>
                            <li><strong>State:</strong> <p>{{ json_decode($data->state_ary)->name ?? '' }}</p></li>
                              <li><strong>City:</strong><p>{{ json_decode($data->city_ary)->name ?? '' }}</p></li>
                            
                             <li>
                              <strong>Address:</strong><p>{{ $data->address ?? '' }}</p>
                            </li>

                         
                            <li>
                              <strong>Location:</strong><p>{{ $data->location ?? '' }}</p>
                            </li>

                            <li>
                              <strong>Zip:</strong><p>{{ $data->zip ?? '' }}</p>
                            </li>


                            <li>
                              <strong>Constitution:</strong><p>{{ $data->constitution ?? '' }}</p>
                            </li>

                            <li>
                              <strong>GST:</strong><p>{{ $data->gst ?? '' }}</p>
                            </li>
                            @if($data->account_status)
                            <li>
                            <strong>Status:</strong> <p class="{{ ($data->account_status==3) ? 'btn btn-success' : 'btn btn-danger'}}">{{ \App\Vendor::accountStatus($data->account_status) }}</p>
                          </li>
                          @endif

                            </ul>
                         </div>
                         <div class="col-md-12 specify_other">
                             
                                <strong>Specify If Constitution Others:</strong> <p>{{ $data->specify_if_other ?? '' }}</p>
                              
                         </div>
                      <div class="row doc_imgswarp">
                         @if($data->pan_file)
                            <div class="col-md-3 doc_imgs">
                              <p><strong>Pan Image</strong></p>
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->pan_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                            </div>
                          @endif
                          @if($data->cancel_cheque_file)
                            <div class="col-md-3 doc_imgs">
                             <p><strong>Cancel Cheque</strong></p>
                                    <div class="zkit_gall_img">
                                      <img src="{{ url('public/'.$data->cancel_cheque_file) }}" alt="user" class="img-fluit edit-product-img" />
                                    </div>
                            </div>
                          @endif
                      </div>
                     
                    </div>
@endif
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })


    })
  </script>