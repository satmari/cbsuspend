@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new Sticker</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/sticker_insert']) !!}

						<div class="panel-body">
						<p>Sticker Name: <span style="color:red;">*</span></p>
							{!! Form::text('sticker', null, ['class' => 'form-control']) !!}
						</div>

						<div class="panel-body">
						<p>Sticker Description: </p>
							{!! Form::text('sticker_desc', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="panel-body">
						<p>Sticker Color: </p>
							{!! Form::input('color','color[0]',null, array('class' => 'form-control-color','placeholder' => 'Enter Color','id' => 'exampleInputTitle1')) !!}
						</div>
						<br>
						
						{!! Form::submit('Add', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/stickers')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection