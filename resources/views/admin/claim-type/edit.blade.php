@extends('layouts.admin')

@section('header') @endsection

@section('body')
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Claim type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item">
              	{{link_to_route('admin.home','Home',[],[])}}
              </li>
              <li class="breadcrumb-item">
                {{link_to_route('admin.claimTypes','Claim type',[],[])}}
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
            <h3 class="card-title">Update Claim type</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">

            {{ Form::open(['route'=>['admin.updateClaimType',$data->slug],'files'=>true])}}

              <div class="row">
                 <div class="col-md-4">
                  <!-- /.form-group -->
                 <div class="form-group">
                    
                    {{ Form::label('Claim type','Claim type') }}
                    {{ Form::text('name',$data->name,['class'=>'form-control','placeholder'=>'Claim type name']) }}
                    
                    <span class="text-danger">{{ $errors->first('name')}}</span>

                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-12">
                      {{ Form::label('Category Name','Category Name') }}
                      
                    <div class="row Goods" id="Goods">
                      @if($data->category)
                        @php $cat = json_decode($data->category); @endphp
                        @forelse($cat as $key => $val)
                        <div class="col-md-3 newGD Goods" id="removeItemRow{{$key}}">
                          <div class="form-group">
                            {{ Form::text('category[]',$val,['class'=>'form-control','placeholder'=>'Category','required'=>true]) }}
                          </div>
                        </div>
                        <div class="col-md-1 ItemRemove" id="rmvBtn{{$key}}">
                          <div class="remRow_box">
                            {!! Html::decode(Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>',['class'=>'btn btn-danger','onClick'=>'removeItemRow('.$key.')']))!!}
                            
                          </div>
                        </div>
                        @empty
                        <div class="col-md-4" id="">
                          <div class="form-group">
                            {{ Form::text('category[]','',['class'=>'form-control','required'=>true,'placeholder'=>'Category Name'])}}
                          </div>
                        </div>
                        @endforelse
                      @endif
                    </div>
                    <div class="col-md-12 text-right">
                      {!! Html::decode(Form::button('<i class="fa fa-plus" aria-hidden="true"></i>',['class'=>'btn btn-primary plus'])) !!}
                      
                    </div>
                  </div>
               
                <!-- /.col -->
               

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

        <!-- SELECT2 EXAMPLE -->
       
        <!-- /.card -->

        
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection

@section('footer')
<script type="text/javascript">
  $('.plus').click(function(){
    var cls = $('.Goods').length;
    var sr=cls+1;
    var cls =cls+Math.floor(1000 + Math.random() * 9000);
    var clone='<div class="col-md-3 newGD Goods" id="removeItemRow'+cls+'"><div class="form-group"><input class="form-control" placeholder="Category Name" required="" id="" name="category[]" type="text"></div></div><div class="col-md-1 ItemRemove" id="rmvBtn'+cls+'"><div class="remRow_box"><button type="button" class="btn btn-danger" onClick="removeItemRow('+cls+')"><i class="fa fa-trash-alt" aria-hidden="true"></i></button></div></div>';
    $('#Goods').append(clone);
    var cls = $('.Goods').length;

    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  });

  function removeItemRow(argument) {
   // alert();
    $('#removeItemRow'+argument).remove();
    $('#rmvBtn'+argument).remove();
    var p_sr=1;
    $("p[class *= 'sr']").each(function(){
        ($(this).text(p_sr++));
    });
  }
</script>
@endsection