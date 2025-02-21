@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit:</div>
				<br>
					{!! Form::model($data , ['method' => 'POST', 'url' => 'update_coment/'.$data->id /*, 'class' => 'form-inline'*/]) !!}

					{!! Form::hidden('id', $data->id, ['class' => 'form-control']) !!}
					

					<div class="panel-body">
					<p>Comment:</p>
						{!! Form::input('string', 'newcoment', $data->coment, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
					</div>

					<div class="panel-body">
					<p>Reason:</p>
						{{-- {!! Form::input('string', 'newreason', $data->reason, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!} --}}
						{!! Form::select('newreason', array(''=>'','first cartoon box'=>'first cartoon box','shading color'=>'shading color','measurement out of tollerance'=>'measurement out of tollerance','contamination/fabric problem'=>'contamination/fabric problem','twisted (leg, sleeve...)'=>'twisted (leg, sleeve...)','different thread color'=>'different thread color', 'intimissimi – first 5 boxes from module' => 'intimissimi – first 5 boxes from module'), $data->reason, array('class' => 'form-control')); !!} 
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
						<a href="{{url('/')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection