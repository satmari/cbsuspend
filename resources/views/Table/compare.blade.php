@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row vertical-center-row">
		<div class="text-center col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Compare table</div>
				<br>
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
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
				           
				           <th>Cartonbox</th>
				           <th>SKU</th>
				           <th>Sticker</th>
				           <th>Box on Shipment <p><span style="color: #b3b3b3;font-weight: normal;font: 5px;font-style: italic;">("Palet" <> 1 AND "Mark for shipment" = NO)</span></p></th>
				           <th>Box shiped</th>
				           <th>Palet in Nav</th>
				           
				        </tr>
				    </thead>
				    <tbody class="searchable">
				    @if ($array)
				    @foreach ($array as $box)
				    	
				        <tr>
				        	
				        	<td>{{ $box['cartonbox'] }}</td>
				        	<td>{{ $box['sku'] }}</td>
				        	<td><span style="color:{{ $box['sticker_color'] }}">{{ $box['sticker'] }}</span></td>
				        	@if ($box['shipment'] == "YES")
				        	<td><span style="color:red !important;font-weight: bold">{{ $box['shipment'] }}</span></td>
							@else
							<td><span style="color:green !important;font-weight: bold">{{ $box['shipment'] }}</span></td>
				        	@endif
				        	<td>{{ $box['posted'] }}</td>
				        	<td>{{ $box['palet'] }}</td>
				        	

						</tr>
				    	
				    @endforeach
				    @endif
				    </tbody>

				</table>
			</div>
		</div>
	</div>
</div>

@endsection