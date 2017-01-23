<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\cbSuspend;
use App\sticker;
use App\location;
use DB;

use Session;

class compareController extends Controller {

	public function index()
	{
		//
		$cb_suspend = DB::connection('sqlsrv')->select(DB::raw("SELECT cartonbox,sticker,sticker_color,style,color,size FROM cb_suspend"));
		// dd($cb_suspend);

		Session::set('compare_array', NULL);

		foreach ($cb_suspend as $box) {
			
			// dd($box->cartonbox);
			$compare = DB::connection('sqlsrv3')->select(DB::raw("SELECT [Box Barcode] as box, [Pallet Number] as palet
				  FROM [Gordon_LIVE].[dbo].[GORDON\$Box Scanning]
				  WHERE [Marked For Shipment] = 0 AND [Pallet Number] != '1'
				  AND [Box Barcode] = '".$box->cartonbox."'"));

			/*$compare = DB::connection('sqlsrv3')->select(DB::raw("SELECT [Box Barcode] as box
				  FROM [Gordon_LIVE].[dbo].[GORDON\$Box Scanning]
				  WHERE [Box Barcode] = '".$box->cartonbox."'")); */

			// dd($compare);

			if ($compare) {
				// dd($compare[0]->box);
				// var_dump($compare[0]->box);

				$boxy = $compare[0]->box;
				$sticker = $box->sticker;
				$sticker_color = $box->sticker_color;
				$palet = $compare[0]->palet;
				$sku = $box->style." ".$box->color."-".$box->size;

				$compare_array = array(
					'cartonbox' => $boxy,
					'sticker' => $sticker,
					'sticker_color' => $sticker_color,
					'palet' => $palet,
					'sku' => $sku,
					'shipment' => "YES");


				Session::push('compare_array',$compare_array);

			} else {
				
				// $boxn = $box->cartonbox;
				// $sticker = $box->sticker;
				// $compare_array = array($boxn => "NO");

				$boxy = $box->cartonbox;
				$sticker = $box->sticker;
				$sticker_color = $box->sticker_color;
				$sku = $box->style." ".$box->color."-".$box->size;

				$compare_array = array(
					'cartonbox' => $boxy,
					'sticker' => $sticker,
					'sticker_color' => $sticker_color,
					'palet' => "",
					'sku' => $sku,
					'shipment' => "NO");

				Session::push('compare_array',$compare_array);
			}
		}

		$array = Session::get('compare_array');
		// dd($array);
		return view('Table.compare',compact('array'));

	}

	public function index_p()
	{
		//
		$cb_suspend = DB::connection('sqlsrv')->select(DB::raw("SELECT cartonbox,sticker,sticker_color,style,color,size FROM cb_suspend"));
		// dd($cb_suspend);

		Session::set('compare_array_p', NULL);

		foreach ($cb_suspend as $box) {
			
			// dd($box->cartonbox);
			$compare = DB::connection('sqlsrv3')->select(DB::raw("SELECT [Box Barcode] as box, [Pallet Number] as palet
				  FROM [Gordon_LIVE].[dbo].[GORDON\$Box Scanning]
				  WHERE [Marked For Shipment] = 0 AND [Pallet Number] != '1'
				  AND [Box Barcode] = '".$box->cartonbox."'"));

			/*$compare = DB::connection('sqlsrv3')->select(DB::raw("SELECT [Box Barcode] as box
				  FROM [Gordon_LIVE].[dbo].[GORDON\$Box Scanning]
				  WHERE [Box Barcode] = '".$box->cartonbox."'")); */

			// dd($compare);

			if ($compare) {
				// dd($compare[0]->box);
				// var_dump($compare[0]->box);

				$boxy = $compare[0]->box;
				$sticker = $box->sticker;
				$sticker_color = $box->sticker_color;
				$palet = $compare[0]->palet;
				$sku = $box->style." ".$box->color."-".$box->size;

				$compare_array = array(
					'cartonbox' => $boxy,
					'sticker' => $sticker,
					'sticker_color' => $sticker_color,
					'palet' => $palet,
					'sku' => $sku,
					'shipment' => "YES");


				Session::push('compare_array_p',$compare_array);

			} else {
				
				// $boxn = $box->cartonbox;
				// $sticker = $box->sticker;
				// $compare_array = array($boxn => "NO");

				// $boxy = $box->cartonbox;
				// $sticker = $box->sticker;
				// $sticker_color = $box->sticker_color;
				// $compare_array = array(
				// 	'cartonbox' => $boxy,
				// 	'sticker' => $sticker,
				// 	'sticker_color' => $sticker_color,
				//	'palet' => "",
				// 	'shipment' => "NO");

				// Session::push('compare_array',$compare_array);
			}
		}

		$array = Session::get('compare_array_p');
		// dd($array);
		return view('Table.compare',compact('array'));


	}

}
