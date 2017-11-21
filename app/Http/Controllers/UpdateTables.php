<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\cbSuspend;
use App\cbLog;
use App\sticker;
use App\palet;
use DB;

use Session;

class UpdateTables extends Controller {

	public function index()
	{
		//

		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cb_suspend ORDER BY id"));
		// dd($data);

		function object_to_array($data)
		{
		    if (is_array($data) || is_object($data))
		    {
		        $result = array();
		        foreach ($data as $key => $value)
		        {
		            $result[$key] = object_to_array($value);
		        }
		        return $result;
		    }
		    return $data;
		}

		foreach ($data as $line) {
			
			// dd($line->po);


			$navision = DB::connection('sqlsrv3')->select(DB::raw("SELECT [No_],
			          case when [Status] = 2 then 'Firm Planned' 
	                  when [Status] = 3 then 'Released' 
	                  when [Status] = 4 then 'Finished'
	                  else convert(varchar(15), [Status]) end as [Status]
				      ,[To be finished]
				      ,[To Be Consumned]
				      ,[Cutting Prod_ Line]
				      ,[Due Date]
					      
					  FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order] as PO left join
					  (SELECT [Document No_]
					      ,sum([PfsOrder Quantity]) as [OrderQuantity], sum([Originally Ordered Qty Calz]) as [Originally Order Qty Clz]
					      ,[PfsBrand] as [Brand]
					  FROM [Gordon_LIVE].[dbo].[GORDON\$Sales Line]
					  where  [Quality Code] = '' and [Line No_] like '1000%'
					  group by [Document No_],[PfsBrand]) as SL on SL.[Document No_] = PO.[No_]
								  
					  where [No_] = :somevariable"
						 
				), array(
					'somevariable' => $line->po
				));

			

			$navision_array = object_to_array($navision);

			$flash = $navision_array[0]['Cutting Prod_ Line'];
			$po_status = $navision_array[0]['Status'];
			// dd($flash);
				
			if ($navision_array[0]['To be finished'] == 1) {
				$tbf = "To be fin";
			} else {
				$tbf = "";
			}

			if ($navision_array[0]['To Be Consumned'] == 1) {
				$tbc = "To be con";
			} else {
				$tbc = "";
			}

			$flag = $tbf." ".$tbc;

			try {
				// $table = new cbSuspend;
				$table = cbSuspend::findOrFail($line->id);

				$table->flash = $flash;
				$table->flag = $flag;
				$table->po_status = $po_status;


				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				// $msg =  $msg.$box['cartonbox']." ";
				// return view('Add.error',compact('msg'));
			}



		}

		return Redirect::to('/');

	}

	

}
