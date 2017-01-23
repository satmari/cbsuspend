@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Change location of palet</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/add_palet_location']) !!}

						<!-- <p>Palet:</p> -->
						<div class="panel-body">
							<p>Scan palet barcode:</p>
							{!! Form::text('palet', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
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