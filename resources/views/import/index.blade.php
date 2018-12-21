@extends('app')

@section('content')
<div class="container container-table">
	<div class="row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Import</div>
				<h3 style="color:red;"></h3>
				<p style="color:red;"></p>

				<div class="panel panel-default">
				<div class="panel-heading">Import already scaned HU for stock take</div>
				
				{!! Form::open(['files'=>'True', 'method'=>'POST', 'action'=>['ImportController@postImportpalet'] ]) !!}
					<div class="panel-body">
						{!! Form::file('file', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import list of HU', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>
							

			</div>
		</div>
		
	</div>
</div>

	

@endsection