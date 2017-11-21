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

class boxRemoveController extends Controller {

	
	public function index()
	{
		//
		$cb_to_remove_array = Session::get('cb_to_remove_array');
		// dd($cb_to_add_array);

		Session::set('cb_to_remove_array', null);
		
		if ($cb_to_remove_array != NULL) {

			$cb_to_remove_array_unique = array_map("unserialize", array_unique(array_map("serialize", $cb_to_remove_array)));
			Session::set('cb_to_remove_array', $cb_to_remove_array_unique);
			
			$sumofcb = 0;
			foreach ($cb_to_remove_array_unique as $line) {
				// foreach ($line as $key) {
					// dd($line);
					// if ($key == 'cartonbox') {
						// dd($line);
						$sumofcb += 1;
					// }
				// }
			}
		}

		return view('Remove.index',compact('cb_to_remove_array_unique','sumofcb'));

	}

	public function removelist(Request $request)
	{	
		$input = $request->all(); 
		$cbcode = $input['cb_to_remove'];

		// $cb_to_remove_array = Session::get('cb_to_remove_array');
		// if ($cb_to_remove_array == NULL) {
		// 	return view('Remove.index');
		// }

		if ($cbcode) {
		
			$cb = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cb_suspend WHERE cartonbox = '".$cbcode."'"));
			// $cb = (object) $cb;
			// dd($cb);
			// dd($cb[0]->id);

			if ($cb) {

				$cbarray = array(
				'id' => $cb[0]->id,
				'cartonbox' => $cb[0]->cartonbox,
				'po' => $cb[0]->po,
				'style' => $cb[0]->style,
				'size' => $cb[0]->size,
				'color' => $cb[0]->color,
				'qty' => $cb[0]->qty
				);

				// dd($cbarray);
				Session::push('cb_to_remove_array',$cbarray);

			} else {
				return Redirect::to('/remove');
			}
		} else {
			
			return Redirect::to('/remove');
		}
		
		$cb_to_remove_array = Session::get('cb_to_remove_array');
		// dd($cb_to_add_array);

		if ($cb_to_remove_array != NULL) {

			$cb_to_remove_array_unique = array_map("unserialize", array_unique(array_map("serialize", $cb_to_remove_array)));
			Session::set('cb_to_remove_array', null);
			Session::set('cb_to_remove_array', $cb_to_remove_array_unique);
			
			$sumofcb = 0;
			foreach ($cb_to_remove_array_unique as $line) {
				// foreach ($line as $key) {
					// dd($line);
					// if ($key == 'cartonbox') {
						// dd($line);
						$sumofcb += 1;
					// }
				// }
			}
		}

		return view('Remove.index',compact('cb_to_remove_array_unique','sumofcb'));
	}

	public function remove(Request $request)
	{
		$cb_to_remove_array = Session::get('cb_to_remove_array');
		// var_dump($cb_to_remove_array);

		if (is_null(Session::get('cb_to_remove_array'))){
			
			return view('Remove.index',compact('cb_to_remove_array_unique','sumofcb'));
		}

		$status = 'UNBLOCK';
		$msg = "";
		
		foreach ($cb_to_remove_array as $box) {

			// dd($box['id']);
			// dd($box['cartonbox']);

			$cb = cbSuspend::findOrFail($box['id']);
			// dd($cb->id);
			
			try {
				$table = new cbLog;

				$table->cartonbox = $cb->cartonbox;
				$table->cartonbox_date = $cb->cartonbox_date;
				$table->po = $cb->po;
				$table->style = $cb->style;
				$table->size = $cb->size;
				$table->color = $cb->color;
				$table->colordesc = $cb->colordesc;
				$table->qty = $cb->qty;
				// $table->standard_qty = $cb->standard_qty;
				$table->po_due_date = $cb->po_due_date;
				
				$table->sticker = $cb->sticker;
				$table->sticker_color = $cb->sticker_color;

				$table->palet_id = $cb->palet_id;

				$table->coment = $cb->coment;
				$table->reason = $cb->reason;
				$table->module = $cb->module;
				$table->flash = $cb->flash;
				$table->flag = $cb->flag;

				$table->po_status = $cb->po_status;

				$table->status = $status;
				$table->block_date = $cb->block_date;
				$table->unblock_date = date("Y-m-d H:i:s");

				$table->save();
						
				$cb->delete();

			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg =  $msg.$cb->cartonbox." ";
				// return view('Add.error',compact('msg'));
			}
		}

		Session::set('cb_to_remove_array', null);
		
		if ($msg != "") {

			$msg = $msg." This boxes unable to unblock and to save in log. ";
			return view('Remove.error',compact('msg'));

		} else {
			return Redirect::to('/');	
		}
	}
}
