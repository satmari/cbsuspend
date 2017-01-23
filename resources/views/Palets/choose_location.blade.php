@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Change location of palet</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'update_location/'.$selected_palet ]) !!}

					{!! Form::hidden('id', $selected_palet, ['class' => 'form-control']) !!}

						<div class="panel-body">
						<p>Choose Location: </p>
		                <select name="location" class="form-control">
		                	<!-- <option value="empty"></option> -->
		                    @foreach ($locations as $line)
		                    <option value="{{ $line->location }}">{{ $line->location }}</option>
		                    @endforeach
		                </select>
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