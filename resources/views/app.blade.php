<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CB Suspend</title>

	<!-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> -->
	<!-- <link href="{{ asset('/css/css.css') }}" rel="stylesheet"> -->
	<!-- <link href="{{ asset('/css/custom.css') }}" rel="stylesheet"> -->


	<link href="{{ asset('/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/bootstrap-table.css') }}" rel='stylesheet' type='text/css'>
	<!-- <link href="{{ asset('/css/jquery.dataTables.min.css') }}" rel='stylesheet' type='text/css'> -->
	<link href="{{ asset('/css/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/custom.css') }}" rel='stylesheet' type='text/css'>
	<link href="{{ asset('/css/app.css') }}" rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="{{ url('/') }}">CB Suspend appliaction</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
					
					<li>
						 <button class="btn btn-default dropdown-toggle" style="margin: 8px 5px !important;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    Tables
							    <span class="caret"></span>
						  </button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    
						    <li><a href="{{ url('/table') }}">Suspend Table</a></li>
							<li><a href="{{ url('/table_log') }}">Log Table</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('/stickers') }}">Stickers</a></li>
							<li><a href="{{ url('/palets') }}">Palets</a></li>
							<li><a href="{{ url('/locations') }}">Locations</a></li>

						</ul>
					</li>
					
					@if(Auth::check())

					<li>
						 <button class="btn btn-default dropdown-toggle" style="margin: 8px 5px !important;" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								    Functions
							    <span class="caret"></span>
						  </button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    
						    <li><a href="{{ url('/add') }}">Suspend box</a></li>
							<li><a href="{{ url('/remove') }}">UnSuspend box</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('/scanbox_s') }}">Change box sticker</a></li>
							<li><a href="{{ url('/scanbox') }}">Change box quantity</a></li>
							<li><a href="{{ url('/scanbox_p') }}">Change box palet</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('/add_palet_location') }}">Change location of palet</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ url('/update') }}">Update Flash,Flag,PO Status, Due date</a></li>

						</ul>
					</li>

					@endif
<!-- 
					<li><a href="{{ url('compare') }}">Compare</a></li>
					<li><a href="{{ url('compare_p') }}">Compare (only problematic)</a></li> -->
				
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						{{--<li><a href="{{ url('/auth/register') }}">Register</a></li>--}}
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
				
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	
	<script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/js/bootstrap-table.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}" type="text/javascript" ></script>
	<!-- <script src="{{ asset('/js/jquery.dataTables.min.js') }}" type="text/javascript" ></script>-->
	<!--<script src="{{ asset('/js/jquery.tablesorter.min.js') }}" type="text/javascript" ></script>-->
	<!--<script src="{{ asset('/js/custom.js') }}" type="text/javascript" ></script>-->
	<script src="{{ asset('/js/tableExport.js') }}" type="text/javascript" ></script>
	<!--<script src="{{ asset('/js/jspdf.plugin.autotable.js') }}" type="text/javascript" ></script>-->
	<!--<script src="{{ asset('/js/jspdf.min.js') }}" type="text/javascript" ></script>-->
	<script src="{{ asset('/js/FileSaver.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/bootstrap-table-export.js') }}" type="text/javascript" ></script>

	<script type="text/javascript">
	   $.ajaxSetup({
	       headers: {
	           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	       }
	   });
	</script>

<script type="text/javascript">
$(function() {
    	
	// $('#po').autocomplete({
	// 	minLength: 3,
	// 	autoFocus: true,
	// 	source: '{{ URL('getpodata')}}'
	// });
	// $('#module').autocomplete({
	// 	minLength: 1,
	// 	autoFocus: true,
	// 	source: '{{ URL('getmoduledata')}}'
	// });

	$('#filter').keyup(function () {

        var rex = new RegExp($(this).val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
	});


	// $('#myTabs a').click(function (e) {
 //  		e.preventDefault()
 //  		$(this).tab('show')
	// });
	// $('#myTabs a:first').tab('show') // Select first tab

	// $(function() {
 //    	$( "#datepicker" ).datepicker();
 //  	});

  	
	$('#sort').bootstrapTable({
    	
	});

	//$('.table tr').each(function(){
  		
  		//$("td:contains('pending')").addClass('pending');
  		//$("td:contains('confirmed')").addClass('confirmed');
  		//$("td:contains('back')").addClass('back');
  		//$("td:contains('error')").addClass('error');
  		//$("td:contains('TEZENIS')").addClass('tezenis');

  		// $("td:contains('TEZENIS')").function() {
  		// 	$(this).index().addClass('tezenis');
  		// }
	//});

	// $('.days').each(function(){
	// 	var qty = $(this).html();
	// 	//console.log(qty);

	// 	if (qty < 7 ) {
	// 		$(this).addClass('zeleno');
	// 	} else if ((qty >= 7) && (qty <= 15)) {
	// 		$(this).addClass('zuto');
	// 	} else if (qty > 15 ) {	
	// 		$(this).addClass('crveno');
	// 	}
	// });


	// $('.status').each(function(){
	// 	var status = $(this).html();
	// 	//console.log(qty);

	// 	if (status == 'pending' ) {
	// 		$(this).addClass('pending');
	// 	} else if (status == 'confirmed') {
	// 		$(this).addClass('confirmed');
	// 	} else {	
	// 		$(this).addClass('back');
	// 	}
	// });

	// $('td').click(function() {
	//    	var myCol = $(this).index();
 	//    	var $tr = $(this).closest('tr');
 	//    	var myRow = $tr.index();

 	//    	console.log("col: "+myCol+" tr: "+$tr+" row:"+ myRow);
	// });

});
</script>
</html>
