@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Choose location where to put carton box?</b></div>
				
				{!! Form::open(['url' => 'set_location']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{{-- 
				<div class="panel-body">
				<p><b>Location: </b></p>
					{!! Form::select('location', ['' => ''] + $locations, null,['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
				</div>
				--}}

				<div class="panel-body">
				<p>Location:</p>
                <select name="location" class="form-control">
                	<option value="empty"></option>
                    @foreach ($locations as $line)
                    <option value="{{ $line->location }}">{{ $line->location }}</option>
                    @endforeach
                </select>
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
