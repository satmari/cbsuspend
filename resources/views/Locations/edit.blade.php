@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit:</div>
				<br>
					{!! Form::model($data , ['method' => 'POST', 'url' => 'location_update/'.$data->id /*, 'class' => 'form-inline'*/]) !!}

					{!! Form::hidden('id', $data->id, ['class' => 'form-control']) !!}
					{{-- 
					<div class="panel-body">
					<p>Location Name:  <span style="color:red;">*</span></p>
						{!! Form::input('string', 'location', null, ['class' => 'form-control']) !!}
					</div>
					--}}

					<div class="panel-body">
					<p>Location Description:</p>
						{!! Form::input('string', 'location_desc', null, ['class' => 'form-control']) !!}
					</div>
						
					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>

					@include('errors.list')

					{!! Form::close() !!}
					<br>
					
					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/locations')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection