@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Add comment</b></div>
				
				{!! Form::open(['url' => 'set_coment']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				<div class="panel-body">
				<p>Comment: </p>
					{!! Form::text('coment', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>

				<div class="panel-body">
				<p>Reason: </p>
				    {{-- {!! Form::text('reason', null, ['class' => 'form-control']) !!} --}}
					{!! Form::select('reason', array(''=>'','first cartoon box'=>'first cartoon box','shading color'=>'shading color','measurement out of tollerance'=>'measurement out of tollerance','contamination/fabric problem'=>'contamination/fabric problem','twisted (leg, sleeve...)'=>'twisted (leg, sleeve...)','different thread color'=>'different thread color', 'intimissimi – first 5 boxes from module' => 'intimissimi – first 5 boxes from module'), '', array('class' => 'form-control')); !!} 
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
