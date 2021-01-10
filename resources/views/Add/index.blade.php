@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Suspend/Block box</b></div>
				
				{!! Form::open(['url' => 'searchinteos']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				<div class="panel-body">
					<p>Scan carton box:</p>
					{!! Form::input('number', 'cb_to_add', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				{{-- 
				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>
				--}}

				@include('errors.list')

				{!! Form::close() !!}

				
				<hr>
				<p><big>List of boxes to suspend</big></p>
				<hr>
				
				@if(isset($cb_to_add_array_unique))
					<table class="table">
						<tr>
							<td>
								Total boxes:
							</td>
					   		<td>
							<big><b>{{ $sumofcb }}</b></big>
					   		</td>
					    </tr>
					</table>
					<table class="table">
						<thead>
							<td>Cartonbox</td>
							<td>Po</td>
							<td>Style</td>
							<td>Size</td>
							<td>Color</td>
							<td>Qty</td>
						</thead>

					@foreach($cb_to_add_array_unique as $array)
						<tr>
							<td>
							@foreach($array as $key => $value)
								@if($key == 'cartonbox')
						    		{{ $value }}
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'po')
						    		<b>{{ $value }}</b>
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'style')
						    		<b>{{ $value }}</b>
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'size')
						    		<b>{{ $value }}</b>
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'color')
						    		<b>{{ $value }}</b>
						    	@endif
						    @endforeach
					   		</td>
					   		<td>
							@foreach($array as $key => $value)
								@if($key == 'qty')
						    		<b>{{ $value }}</b>
						    	@endif
						    @endforeach
					   		</td>
					   		
					    </tr>

					@endforeach
						{{-- 
						<tfoot>
						<tr>
							<td>
								Total boxes:
							</td>
					   		<td>
							<big><b>{{ $sumofcb }}</b></big>
					   		</td>
					    </tr>
						</tfoot>
						--}}
					</table>
				@endif
				
				<br>
				{!! Form::open(['url' => 'sticker']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">


				<div class="panel-body">
					{!! Form::submit('Suspend list', ['class' => 'btn btn-success btn-lg center-block']) !!}
				</div>

				@include('errors.list')

				{!! Form::close() !!}

				<br>
				<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
