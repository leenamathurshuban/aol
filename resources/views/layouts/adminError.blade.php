@if(Session::has('success'))
	
<div class="card-header text-success hidePrint">
                <h3 class="card-title">{{Session::get('success')}}</h3>
 </div>

@elseif(Session::has('failed'))

<div class="card-header text-danger hidePrint">
                <h3 class="card-title">{{Session::get('failed')}}</h3>
 </div>

 @elseif(Session::has('error'))

<div class="card-header text-danger hidePrint">
                <h3 class="card-title">{{Session::get('error')}}</h3>
 </div>

@else

@endif