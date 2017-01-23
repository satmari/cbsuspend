@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new Palet</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/palet_insert']) !!}

						<div class="panel-body">
						<p>Palet Name: <span style="color:red;">*unique</span></p>
							{!! Form::text('palet', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						
						<div class="panel-body">
						<p>Palet Barcode: <span style="color:red;">*unique</span></p>
							{!! Form::text('palet_barcode', null, ['class' => 'form-control']) !!}
						</div>
						<br>
						
						{!! Form::submit('Add', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/palets')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection