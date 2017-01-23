@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Change box quantity</b></div>
				
				{!! Form::open(['url' => 'update_quantity/'.$id]) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				<div class="panel-body">
					<p>Change quantity:</p>
					{!! Form::input('number', 'newqty', $qty, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				<div class="panel-body">
					{!! Form::submit('Confirm', ['class' => 'btn btn-success btn-lg center-block']) !!}
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
