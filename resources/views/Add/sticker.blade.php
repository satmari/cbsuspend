@extends('app')

@section('content')
<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Choose sticker of carton box</b></div>
				
				{!! Form::open(['url' => 'set_sticker']) !!}
				<input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">

				{{-- 
				<div class="panel-body">
				<p><b>Sticker: </b></p>
					{!! Form::select('sticker', ['' => ''] + $stickers, null,['class' => 'form-control']) !!}
				</div>
				--}}

				<div class="panel-body">
				<p>Sticker Color:</p>
                <select name="sticker" class="form-control">
                	<option value="empty"></option>
                    @foreach ($stickers as $line)
                    <option value="{{ $line->sticker }}" style="color:{{ $line->sticker_color}}">{{ $line->sticker }}</option>
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
