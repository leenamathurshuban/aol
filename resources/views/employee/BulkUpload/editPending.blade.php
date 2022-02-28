@extends('layouts.employee')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Bulk upload Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
 
              <li class="breadcrumb-item">
              	{{link_to_route('employee.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('employee.pendingBulkUpload','Pending Request',[],[])}}
              </li>
              <li class="breadcrumb-item active">Update</li>
            </ol> 
          </div>
        </div> 
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Update Form</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            {{ Form::open(['route'=>['employee.BulkUploadUpdate',$data->order_id,$page],'files'=>true])}}
              <div class="row">

                 <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Category','Category') }}
                    {{ Form::select('category',\App\BulkUpload::category(),$data->category,['class'=>'form-control custom-select select2','placeholder'=>'Choose category','id'=>'category','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('category')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('Specify details','Specify details') }}
                    {{ Form::text('specify_detail',$data->specify_detail,['class'=>'form-control','placeholder'=>'Specify details','id'=>'specify_detail']) }}
                    <span class="text-danger">{{ $errors->first('specify_detail')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Bank Formate','Bank Formate') }}
                    {{ Form::select('bank_formate',\App\BulkUpload::bank(),$data->bank_formate,['class'=>'form-control custom-select select2','placeholder'=>'Choose Bank Formate','id'=>'bank_formate','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('bank_formate')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Payment Type','Payment Type') }}
                    {{ Form::select('payment_type',\App\BulkUpload::paymentType(),$data->payment_type,['class'=>'form-control custom-select select2','placeholder'=>'Choose Payment Type','id'=>'payment_type','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('payment_type')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('Apex','Apex') }}
                        {{ Form::select('apex',$apexes,$data->apexe_id,['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                        <span class="text-danger">{{ $errors->first('apex')}}</span>
                      </div>
                    </div>

                <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('CSV Attachment','CSV Attachment') }}
                        {!!Form::file('bulk_attachment_file',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                        @if($errors->has('bulk_attachment_file'))
                            <p class="text-danger">{{$errors->first('bulk_attachment_file')}}</p>
                        @endif

                       {!! Html::decode(link_to('public/'.$data->bulk_attachment_path,\App\Helpers\Helper::getDocType($data->bulk_attachment_path,$data->bulk_attachment_type),['target'=>'_blank'])) !!}

                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                      {!!Form::label('Attachment Description', 'Attachment Description')!!}
                             {!!Form::textarea('bulk_attachment_description',$data->bulk_attachment_description,['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('bulk_attachment_description'))
                              <p class="text-danger">{{$errors->first('bulk_attachment_description')}}</p>
                            @endif
                        </div>
                    </div>
                <!-- /.col  -->
              </div>

              <div class="col-md-12">
                  <h3>Saved Files</h3>
                    <div class="row savedFile">
                      @forelse($data->bulkReqImage as $key => $val)
                      <div class="col-md-2">
                        <div class="savedimg_box">
                        {!! Html::decode(link_to('public/'.$val->bulk_upload_file_path,\App\Helpers\Helper::getDocType($val->bulk_upload_file_path,$val->bulk_upload_file_type),['target'=>'_blank','data-toggle'=>'tooltip','data-placement'=>'top','title'=>$val->bulk_upload_file_description])) !!}
                        {!! Html::decode(link_to_route('employee.bulkUploadPendIMG','<i class="fa fa-trash-alt" aria-hidden="true"></i>',$val->id,['class'=>'btn btn-danger'])) !!}
                         </div>
                      </div>
                    @empty
                    <p><strong>Files not found.</strong></p>
                    @endforelse
                    </div>
                </div>
                <div class="row imgSection">
                  <div class="col-md-3" id="IMAGESEC">
                        <div class="form-group">
                          {!!Form::label('Attachments', 'Attachments')!!}
                             {!!Form::file('supporting_file[]',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                          @if($errors->has('supporting_file'))
                              <p class="text-danger">{{$errors->first('supporting_file')}}</p>
                            @endif
                        </div>
                        <div class="form-group">
                          {!!Form::label('description', 'Attachment Description')!!}
                             {!!Form::textarea('supporting_file_description[]','',['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('supporting_file_description'))
                              <p class="text-danger">{{$errors->first('supporting_file_description')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 text-left editIcon">
                      {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary addIMg'])) !!}
                      {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger removeIMg','style'=>'display:none'])) !!}
                    </div>
              </div>
               
            <!-- /.row -->
              <div class="card-footer">
                {!! Form::submit('Update',['class'=>'btn btn-outline-primary']) !!}
              </div>
           {{ Form::close() }}
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

 <div class="modal fade" id="modal-default">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header noprint">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body P-0" id="modal-body">

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
    </div>
  
@endsection

@section('footer')
<script type="text/javascript">
  $('.addIMg').click(function() {
    var cls = $('.IMGRow').length;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 IMGRow"> <div class="form-group"> <label for="file">Attachment</label> <input class="dropify form-control" data-default-file="" id="input-file-now-custom-1" name="supporting_file[]" type="file" required> </div><div class="form-group"> <label for="description">Attachment Description</label> <textarea class="form-control" rows="3" name="supporting_file_description[]" cols="50" placeholder="Description about attachment file"></textarea> </div></div>';
      $('#IMAGESEC').after(clone);
      var cls = $('.IMGRow').length;
      if (cls) {
        $('.removeIMg').show();
      }
  });
  $('.removeIMg').click(function(){
      var cls = $('.IMGRow').length;
      if (cls == 1) {
        $('.removeIMg').hide();
      }
      $('.IMGRow').last().remove();
  });
</script>
@endsection