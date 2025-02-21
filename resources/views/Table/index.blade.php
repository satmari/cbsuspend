@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row vertical-center-row">
		<div class="text-center">
			<div class="panel panel-default">
				<div class="panel-heading">Suspend table</div>
				{{--<a href="{{ url('/export') }}" class="btn btn-info btn-s">Export in CSV</a> --}}
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>
                <table class="table table-striped table-bordered" id="sort" 
                data-show-export="true"
                data-export-types="['excel']"
                >
                <!--
                data-show-export="true"
                data-export-types="['excel']"
                data-search="true"
                data-show-refresh="true"
                data-show-toggle="true"
                data-query-params="queryParams" 
                data-pagination="true"
                data-height="300"
                data-show-columns="true" 
                data-export-options='{
                         "fileName": "preparation_app", 
                         "worksheetName": "test1",         
                         "jspdf": {                  
                           "autotable": {
                             "styles": { "rowHeight": 20, "fontSize": 10 },
                             "headerStyles": { "fillColor": 255, "textColor": 0 },
                             "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                           }
                         }
                       }'
                -->
				    <thead>
				        <tr>
				           {{-- <th>id</th> --}}
				           <th>Cartonbox</th>
				           <th data-sortable="true">Module</th>
				           <th>Cartonbox date</th>
				           <th>Po</th>
				           <th>Po status</th>
				           <th>Flash</th>
				           <th>Flag</th>
				           <th>Po Due Date</th>
				           <th data-sortable="true">Day diff</th>
				           <th data-sortable="true">SKU</th>
				           <th>Color Desc</th>
				           <th>Qty</th>
				           <th>Sticker</th>
				           <th>Palet</th>
				           <th>Location</th>
				           <th>Status</th>
				           <th>Block date</th>
				           <th>Unblock date</th>
				           <th>Comment</th>
				           <th>Reason</th>
				           <th></th>
				        </tr>
				    </thead>
				    <tbody class="searchable">
				    
				    @foreach ($data as $d)
				    	
				        <tr>
				        	{{-- <td>{{ $d->id }}</td> --}}
				        	<td>{{ $d->cartonbox }}</td>
				        	<td>{{ $d->module}}</td>
				        	<td>{{ Carbon\Carbon::parse($d->cartonbox_date)->format('d.m.Y H:i:s') }}</td>
				        	<td>{{ $d->po }}</td>
				        	<td>{{ $d->po_status }}</td>
				        	<td>{{ $d->flash}}</td>
				        	<td>{{ $d->flag}}</td>
				        	<td>{{ Carbon\Carbon::parse($d->po_due_date)->format('d.m.Y') }}</td>
				        	<td data-sortable="true">{{ Carbon\Carbon::parse($d->po_due_date)->diffForHumans(Carbon\Carbon::now()) }}</td>
				        	<td><pre>{{ $d->sku }}</pre></td>
				        	<td>{{ $d->colordesc }}</td>
				        	<td>{{ $d->qty }}</td>
				        	<td><span style="color:{{ $d->sticker_color }};
				        		text-shadow:   -0.5px -0.5px 0 #000,  
				        					    0.5px -0.5px 0 #000,
				        					    -0.5px 0.5px 0 #000,
				        					    0.5px 0.5px 0 #000;">{{ $d->sticker }}</span></td>
    					    <td>{{ $d->palet }}</td>
				        	<td>{{ $d->location }}</td>
				        	<td>{{ $d->status }}</td>
				        	<td>{{ substr($d->block_date, 0, 19) }} </td>
				        	{{--<td>{{ Carbon\Carbon::parse($d->block_date)}}</td> --}}
				        	<td>{{ substr($d->unblock_date, 0, 19) }} </td>
				        	<td>{{ $d->coment }} </td>
				        	<td>{{ $d->reason }} </td>
				        	<td>
				        	@if(Auth::check())
				        	  	<a href="{{ url('edit_coment/'.$d->id) }}" class="btn btn-info btn-xs center-block">Edit</a>
				        	@endif
				        	</td>
						</tr>
				    
				    @endforeach
				    </tbody>

				</table>
			</div>
		</div>
	</div>
</div>

@endsection