<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\cbSuspend;
use App\sticker;
use App\palet;
use DB;

use Session;

class boxAddController extends Controller {

	
	public function index()
	{
		//
		$cb_to_add_array = Session::get('cb_to_add_array');
		// dd($cb_to_add_array);
		
		Session::set('cb_to_add_array', null);
		Session::set('cb_to_remove_array', null);
		Session::set('sticker_array', null);
		Session::set('location', null);
		Session::set('coment', null);
		Session::set('reason', null);

		if ($cb_to_add_array != NULL) {

			$cb_to_add_array_unique = array_map("unserialize", array_unique(array_map("serialize", $cb_to_add_array)));
			Session::set('cb_to_add_array', $cb_to_add_array_unique);
			
			$sumofcb = 0;
			foreach ($cb_to_add_array_unique as $line) {
				// foreach ($line as $key) {
					// dd($line);
					// if ($key == 'cartonbox') {
						// dd($line);
						$sumofcb += 1;
					// }
				// }
			}
		}

		return view('Add.index',compact('cb_to_add_array_unique','sumofcb'));
	}

	public function searchinteos(Request $request)
	{
		//add CB
		//validation
		// $this->validate($request, ['cb_to_add'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$cbcode = $input['cb_to_add'];
		// dd($cbcode);
		//700000307965

		if ($cbcode) {

			$inteos = DB::connection('sqlsrv2')->select(DB::raw("SELECT 
				cb.BoxNum,
				cb.Produced,
				cb.EDITDATE,
				po.POnum,
				po.BoxQuant,
				po.POClosed,
				st.StyCod,
				sku.Variant,
				sku.ClrDesc,
				m.ModNam,
				wh.BoxQuant as whQty

				FROM            dbo.CNF_CartonBox AS cb 
				LEFT OUTER JOIN dbo.CNF_PO AS po ON cb.IntKeyPO = po.INTKEY 
				LEFT OUTER JOIN dbo.CNF_SKU AS sku ON po.SKUKEY = sku.INTKEY
				LEFT OUTER JOIN dbo.CNF_STYLE AS st ON sku.STYKEY = st.INTKEY
				LEFT OUTER JOIN dbo.CNF_BlueBox AS bb ON cb.BBcreated = bb.INTKEY
				LEFT OUTER JOIN dbo.CNF_Modules AS m ON cb.Module = m.Module
				LEFT OUTER JOIN dbo.CNF_WareHouse AS wh ON cb.BoxNum = wh.BoxNum
				
				WHERE			cb.BoxNum = :somevariable

				GROUP BY		cb.BoxNum,
								cb.Produced,
								cb.EDITDATE,
								po.POnum,
								po.BoxQuant,
								po.POClosed,
								st.StyCod,
								sku.Variant,
								sku.ClrDesc,
								m.ModNam,
								wh.BoxQuant"
				), array(
					'somevariable' => $cbcode
			));

			
			if (empty($inteos)) {
				$msg = 'Cartonbox not exist on in Inteos';
			    
			} else {

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
			
		    	$inteos_array = object_to_array($inteos);
		    	// dd($inteos_array);

		    	$cartonbox = $inteos_array[0]['BoxNum'];
		    	$cartonbox_date = $inteos_array[0]['EDITDATE'];
		    	$po = $inteos_array[0]['POnum'];

		    	$po_status = $inteos_array[0]['POClosed']; // ?
		    	
		    	$style = $inteos_array[0]['StyCod'];
		    	$variant = $inteos_array[0]['Variant'];
		    	$colordesc = $inteos_array[0]['ClrDesc'];

		    	$qty = $inteos_array[0]['Produced'];
		    	$wh_qty = $inteos_array[0]['whQty'];

		    	$standard_qty = $inteos_array[0]['BoxQuant']; // ?

		    	$module = $inteos_array[0]['ModNam'];

		    	// list($color, $size) = explode('-', $variant);

				$brlinija = substr_count($variant,"-");
							// echo $brlinija." ";

				if ($brlinija == 2)
				{
					list($color, $size1, $size2) = explode('-', $variant);
					$size = $size1."-".$size2;
					// echo $color." ".$size;	
				} else {
					list($color, $size) = explode('-', $variant);
					// echo $color." ".$size;
				}


		    	// Nav
      			/*
      			$navision = DB::connection('sqlsrv3')->select(DB::raw("SELECT [Due Date],[Cutting Prod_ Line]
						  FROM [Gordon_LIVE].[dbo].[GORDON\$Production Order]
						  WHERE [No_] = :somevariable"
					), array(
						'somevariable' => $po
				));
				*/

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
					'somevariable' => $po
				));

				$fr = DB::connection('sqlsrv4')->select(DB::raw("SELECT 
						substring(PO.[ORDER_NAME],1,14) as Komesa,
						--substring (PO.[ORDER_NAME],charindex(':',[ORDER_NAME],18)+2, charindex('=',[ORDER_NAME])-(charindex(':',[ORDER_NAME],18)+2) ) as Size,
					    DLV.[DEL_DATE]
					FROM [FR_Gordon].[dbo].[_ORDERS] as PO 
					left join   
					  (SELECT [ORDER_ID]
					      ,[DEL_DATE]
					      ,[ORIG_DEL_DATE]
					      ,sum([DEL_QTY]) as qty, [EXTN_DEL_DATE]
					  FROM [FR_Gordon].[dbo].[_ORDER_DELIVERIES]
					  group by [ORDER_ID]
					      ,[DEL_DATE]
					      ,[ORIG_DEL_DATE], [EXTN_DEL_DATE]) as DLV on DLV.[ORDER_ID] = PO.[ORDER_ID] 
						left join 
					      (SELECT  [PRODUCT_ID],
									substring([PRODUCT_NAME],1,charindex(' ',[PRODUCT_NAME])) as Style,
									substring([PRODUCT_NAME],charindex(' ',[PRODUCT_NAME]),charindex('=',[PRODUCT_NAME])-charindex(' ',[PRODUCT_NAME])) as [Variant Code],
									[DESCRIPTION]
					      FROM [FR_Gordon].[dbo].[_PRODUCTS]
						  where charindex('=',[PRODUCT_NAME]) is not null  and [DESCRIPTION] <> '' and len([PRODUCT_NAME]) > 15) as PRO on PRO.[PRODUCT_ID] = PO.[PRODUCT_ID]
					where substring(PO.[ORDER_NAME],1,14) = :somevariable and charindex(' ',[ORDER_NAME]) = 0
					group by substring(PO.[ORDER_NAME],1,14),DLV.[DEL_DATE],PO.[ORDER_NAME]
				"), array('somevariable' => $po));

				// dd($fr);
				// dd($fr[0]->DEL_DATE);

				$navision_array = object_to_array($navision);

				$po_due_date = $navision_array[0]['Due Date'];
				$flash = $navision_array[0]['Cutting Prod_ Line'];
				$po_status = $navision_array[0]['Status'];
				
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

				if (!isset($fr[0]->DEL_DATE)) {
					$po_due_date = '1900-01-01';
				}
				

				$cbarray = array(
				'cartonbox' => $cartonbox,
				'cartonbox_date' => $cartonbox_date,
				'po' => $po,
				'flash' => $flash,
				'flag' => $flag,
				'po_status' => $po_status,
				'style' => $style,
				'size' => $size,
				'color' => $color,
				'colordesc' => $colordesc,
				'qty' => $wh_qty,
				'standard_qty' => $standard_qty,
				'po_due_date' => $po_due_date,
				'module' => $module
				);
				// dd($cbarray);

				Session::push('cb_to_add_array',$cbarray);

			}
		} else {
			// return view('Add.index');
			return Redirect::to('/add');
		}


		$cb_to_add_array = Session::get('cb_to_add_array');
		// dd($cb_to_add_array);

		if ($cb_to_add_array != NULL) {

			$cb_to_add_array_unique = array_map("unserialize", array_unique(array_map("serialize", $cb_to_add_array)));
			Session::set('cb_to_add_array', null);
			Session::set('cb_to_add_array', $cb_to_add_array_unique);
			
			$sumofcb = 0;
			foreach ($cb_to_add_array_unique as $line) {
				// foreach ($line as $key) {
					// dd($line);
					// if ($key == 'cartonbox') {
						// dd($line);
						$sumofcb += 1;
					// }
				// }
			}
		}

		return view('Add.index',compact('cb_to_add_array_unique','sumofcb'));
	}

	public function sticker(Request $request)
	{
		$cb_to_add_array = Session::get('cb_to_add_array');
		if ($cb_to_add_array == NULL) {
			return view('Add.index');
		}
		
		$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
		$stickers = (object) $stickers;

		// dd($stickers);
		
		return view('Add.sticker',compact('stickers'));
	}

	public function set_sticker(Request $request)
	{
		// Validate
		$this->validate($request, ['sticker'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$sticker = $input['sticker'];
		// dd($sticker);

		Session::set('sticker_array', null);

		if ($sticker != 'empty') {
			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_color FROM stickers WHERE sticker = '".$sticker."'"));
			// dd($stickers);
			$sticker_color = $stickers[0]->sticker_color;
			// dd($sticker_color);		

			$sticker_array = array(
				'sticker' => $sticker,
				'sticker_color' => $sticker_color
			);
				
			Session::push('sticker_array',$sticker_array);

		} else {
			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
			$stickers = (object) $stickers;

			return view('Add.sticker',compact('stickers'));
		}
			
		return view('Add.palet');
	}

	public function set_palet(Request $request)
	{
		// Validate
		// $this->validate($request, ['palet'=>'required']);
		$input = $request->all(); 
		//var_dump($input);

		Session::set('palet', null);
		
		// dd($input['palet']);
		$palet = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM palets WHERE palet = '".$input['palet']."'"));
		// dd($palet);

		if (count($palet) > 0 ) {
			// dd($palet[0]->id);
	
			Session::set('palet', $palet[0]->id);
			// return Redirect::to('/set_coment');
			return view('Add.coment');

		} else {
			
			return view('Add.palet');
		}
	}
	
	public function set_coment(Request $request) 
	{
		// Validate
		// $this->validate($request, ['coment'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$coment = $input['coment'];
		$reason = $input['reason'];
		// dd($coment);

		Session::set('coment',$coment);
		Session::set('reason',$reason);

		return Redirect::to('/addlist');	
	}
	
	public function addlist(Request $request)
	{

		$cb_to_add_array = Session::get('cb_to_add_array');
		// var_dump($cb_to_add_array);
		$sticker_array = Session::get('sticker_array');
		// var_dump($sticker_array);
		$palet_id = Session::get('palet');
		// dd($palet);
		$coment = Session::get('coment');
		$reason = Session::get('reason');
		// var_dump($coment);


		if (is_null(Session::get('cb_to_add_array'))){
			
			return view('Add.index',compact('cb_to_add_array_unique','sumofcb'));
		}

		if (is_null(Session::get('sticker_array'))){
			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
			$stickers = (object) $stickers;

			return view('Add.sticker',compact('stickers'));
		}

		if (is_null(Session::get('palet'))){
			
			return view('Add.palet');
		} else {
			// $palets = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM palets WHERE id = '".$palet."'"));
			// dd($palets);
			// $palet_id = $palets[0]->id;

		}

		$sticker = $sticker_array[0]['sticker'];
		$sticker_color = $sticker_array[0]['sticker_color'];
		// dd($sticker_color);

		$status = 'BLOCK';
		
		$msg = "";
		
		foreach ($cb_to_add_array as $box) {
			// dd($box['cartonbox']);
			try {
				$table = new cbSuspend;

				$table->cartonbox = $box['cartonbox'];
				$table->cartonbox_date = $box['cartonbox_date'];
				$table->po = $box['po'];
				
				$table->style = $box['style'];
				$table->size = $box['size'];
				$table->color = $box['color'];
				$table->colordesc = $box['colordesc'];
				$table->qty = $box['qty'];
				// $table->standard_qty = $box['standard_qty'];
				$table->po_due_date = $box['po_due_date'];
				
				$table->sticker = $sticker;
				$table->sticker_color = $sticker_color;

				$table->palet_id = $palet_id;

				$table->coment = $coment;
				$table->reason = $reason;
				$table->module = $box['module'];
				$table->flash = $box['flash'];
				$table->flag = $box['flag'];

				$table->po_status = $box['po_status'];

				$table->status = $status;
				$table->block_date = date("Y-m-d H:i:s");

				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg =  $msg.$box['cartonbox']." ";
				// return view('Add.error',compact('msg'));
			}
		}

		Session::set('cb_to_add_array', null);
		Session::set('sticker_array', null);
		Session::set('palet', null);
		Session::set('coment', null);
		Session::set('reason', null);

		if ($msg != "") {

			$msg = $msg." This box unable to block. Check if box already suspended! If not, call IT.";
			return view('Add.error',compact('msg'));

		} else {

			if ($box['flash'] != '') {
				$msg = "This production order is FLASH !!!";
				return view('Add.warrning',compact('msg'));
			}
			return Redirect::to('/');	
		}

		
	}

	// Change Quantity
	public function scanbox()
	{
		//
		return view('Add.scanbox');
	}

	public function change_quantity(Request $request)
	{
		// Validate
		$this->validate($request, ['cb'=>'required']);
		$input = $request->all();

		$box = $input['cb'];
		// dd($box);

		$cb = DB::connection('sqlsrv')->select(DB::raw("SELECT id, qty FROM cb_suspend WHERE cartonbox = '".$box."'"));

		if (count($cb) > 0) {

			$id = $cb[0]->id;
			$qty = $cb[0]->qty;

			return view('Add.change_quantity',compact('id','qty'));

		} else {
			return view('Add.scanbox');
		}
	}

	public function update_quantity($id, Request $request)
	{
		// Validate
		$this->validate($request, ['newqty'=>'required']);
		$input = $request->all();

		$newqty = $input['newqty'];
		// dd($newqty);


		$table = cbSuspend::findOrFail($id);
		$input = $request->all(); 
		//dd($input);

		try {		
			$table->qty = $newqty;
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to change qty in table";
			return view('Add.error',compact('msg'));
		}

		return Redirect::to('/');
	}

	// Change Palet
	public function scanbox_p()
	{
		//
		return view('Add.scanbox_p');
	}

	public function change_palet(Request $request)
	{
		// Validate
		$this->validate($request, ['cb'=>'required']);
		$input = $request->all();

		$box = $input['cb'];
		// dd($box);

		$cb = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM cb_suspend WHERE cartonbox = '".$box."'"));

		if (count($cb) > 0 ){

			$id = $cb[0]->id;
			return view('Add.change_palet',compact('id'));

		} else {
			return view('Add.scanbox_p');	
		}
		
	}

	public function update_palet($id, Request $request)
	{
		// Validate
		// $this->validate($request, ['newpalet'=>'required']);
		$input = $request->all();

		$newpalet = $input['newpalet'];
		// dd($newpalet);

		$palets = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM palets WHERE palet = '".$newpalet."'"));

		if (count($palets) > 0 ){

			$table = cbSuspend::findOrFail($id);
		
			try {		
				$table->palet_id = $palets[0]->id;
				
				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg = "Problem to change palet in table";
				return view('Add.error',compact('msg'));
			}

			return Redirect::to('/');
		} else {
			return view('Add.change_palet',compact('id'));
		}

	}

	// Change Sticker
	public function scanbox_s()
	{
		//
		return view('Add.scanbox_s');
	}

	public function change_sticker(Request $request)
	{
		// Validate
		$this->validate($request, ['cb'=>'required']);
		$input = $request->all();

		$box = $input['cb'];
		// dd($box);

		$cb = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM cb_suspend WHERE cartonbox = '".$box."'"));

		if (count($cb) > 0 ){

			$id = $cb[0]->id;

			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
			$stickers = (object) $stickers;

			return view('Add.change_sticker',compact('id','stickers'));

		} else {
			return view('Add.scanbox_s');	
		}
		
	}

	public function update_sticker($id, Request $request)
	{
		// Validate
		// $this->validate($request, ['newpalet'=>'required']);
		$input = $request->all();

		if (isset($input['newsticker'])) {
			$newsticker = $input['newsticker'];
			// dd($newsticker);


			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker,sticker_color FROM stickers WHERE sticker = '".$newsticker."'"));
			// dd($stickers);

			if (count($stickers) > 0 ){

				$table = cbSuspend::findOrFail($id);
			
				try {		
					$table->sticker = $stickers[0]->sticker;
					$table->sticker_color = $stickers[0]->sticker_color;
					
					$table->save();
				}
				catch (\Illuminate\Database\QueryException $e) {
					$msg = "Problem to change sticker in table";
					return view('Add.error',compact('msg'));
				}

				return Redirect::to('/');
			} else {
				$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
				$stickers = (object) $stickers;
				return view('Add.change_sticker',compact('id','stickers'));
			}
		} else {
			$stickers = DB::connection('sqlsrv')->select(DB::raw("SELECT sticker, sticker_desc, sticker_color FROM stickers ORDER BY id asc"));
			$stickers = (object) $stickers;
			return view('Add.change_sticker',compact('id','stickers'));
		}
		
	}

}


