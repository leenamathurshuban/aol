@extends('layouts.employee')

@section('header') @endsection
 
@section('body') 
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Bulk Upload Form</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
          	{{link_to_route('employee.home','Home',[],[])}}
          </li>
          <li class="breadcrumb-item">
            {{link_to_route('employee.pendingBulkUpload','Pending Request',[],[])}}
          </li>
          <li class="breadcrumb-item active">Add</li>
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
       {{-- <h3 class="card-title">Add Bulk Upload Form</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>--}}
        <div class="col-md-12">
              {{ link_to_route('employee.bulkUploadExport','WithIn SBI Format','within',['class'=>'btn btn-primary btn-xs bulkUploadBtn']) }}
            
              {{ link_to_route('employee.bulkUploadExport','Outside SBI Format','outside',['class'=>'btn btn-primary btn-xs bulkUploadBtn']) }}
            
              {{ link_to_route('employee.bulkUploadExport','Combined Format','combined',['class'=>'btn btn-primary btn-xs bulkUploadBtn']) }}
        </div>
        <div class="text text-danger col-md-12">
            @if ($failures = Session::get('sheeterror'))
                @foreach($failures->errors() as $failure)
                    There was an error on row {{ $failures->row() }}. {{ $failure }}
                @endforeach
            @endif
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        {{ Form::open(['route'=>['employee.BulkUploadSave'],'files'=>true])}}
          <div class="row">

               <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Category','Category') }}
                    {{ Form::select('category',\App\BulkUpload::category(),'',['class'=>'form-control custom-select select2','placeholder'=>'Choose category','id'=>'category','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('category')}}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('Specify details','Specify details') }}
                    {{ Form::text('specify_detail','',['class'=>'form-control','placeholder'=>'Specify details','id'=>'specify_detail']) }}
                    <span class="text-danger">{{ $errors->first('specify_detail')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Bank Formate','Bank Formate') }}
                    {{ Form::select('bank_formate',\App\BulkUpload::bank(),'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Bank Formate','id'=>'bank_formate','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('bank_formate')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Payment Type','Payment Type') }}
                    {{ Form::select('payment_type',\App\BulkUpload::paymentType(),'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Payment Type','id'=>'payment_type','requird'=>true]) }}
                    <span class="text-danger">{{ $errors->first('payment_type')}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('Apex','Apex') }}
                    {{ Form::select('apex',$apexes,'',['class'=>'form-control custom-select select2','placeholder'=>'Choose Apex','id'=>'']) }}
                    <span class="text-danger">{{ $errors->first('apex')}}</span>
                  </div>
                </div>
                {{--
                  <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('Description','Short Description') }}
                    {{ Form::textarea('description','',['class'=>'form-control','placeholder'=>'Short Description','rows'=>3]) }}
                    <span class="text-danger">{{ $errors->first('description')}}</span>
                  </div>
                </div>
                  --}}

                  <div class="col-md-6">
                     <div class="form-group">
                        {{ Form::label('CSV Attachment','CSV Attachment') }}
                        {!!Form::file('bulk_attachment_file',['class'=>'dropify form-control','data-default-file'=>'','id'=>'input-file-now-custom-1'])!!}
                        @if($errors->has('bulk_attachment_file'))
                            <p class="text-danger">{{$errors->first('bulk_attachment_file')}}</p>
                        @endif
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                      {!!Form::label('Attachment Description', 'Attachment Description')!!}
                             {!!Form::textarea('bulk_attachment_description','',['class'=>'form-control','rows'=>3,'placeholder'=>'Description about attachment file'])!!}
                          @if($errors->has('bulk_attachment_description'))
                              <p class="text-danger">{{$errors->first('bulk_attachment_description')}}</p>
                            @endif
                        </div>
                    </div>
                
            <!-- /.col  -->
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
            {!! Form::submit('Save',['class'=>'btn btn-outline-primary']) !!}
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