<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\palet;
use DB;

class PaletsController extends Controller {

	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM palets ORDER BY id"));
		return view('Palets.index', compact('data'));
	}

	public function add_new_palet()
	{
		return view('Palets.add');
	}

	public function palet_insert(Request $request)
	{
		//validation
		$this->validate($request, ['palet'=>'required','palet_barcode'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$palet = $input['palet'];
		$palet_barcode = $input['palet_barcode'];

		// dd($palet);
		// Record 
		try {
			$table = new palet;

			$table->palet = $palet;
			$table->palet_barcode = $palet_barcode;

			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save palet in table";
			return view('Palets.error',compact('msg'));
		}

		return Redirect::to('/palets');
	}

	public function edit_palet($id)
	{
		$data = palet::findOrFail($id);		
		return view('Palets.edit', compact('data'));

	}

	public function update($id, Request $request) 
	{
		//
		$this->validate($request, ['palet_barcode'=>'required']);

		$table = palet::findOrFail($id);		
		
		$input = $request->all(); 
		//dd($input);

		try {		
			// $table->palet = $input['palet'];
			$table->palet_barcode = $input['palet_barcode'];
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('Palets.error');			
		}
		
		return Redirect::to('/palets');
	}

	public function add_palet_location() 
	{
		//
		return view('Palets.add_palet_location');
	}

	public function choose_location(Request $request) 
	{
		//
		$this->validate($request, ['palet'=>'required']);

		$input = $request->all(); 
		// var_dump($input);
	
		$palet = DB::connection('sqlsrv')->select(DB::raw("SELECT id FROM palets WHERE palet = '".$input['palet']."'"));
		// dd($palet);

		if (empty($palet)) {
				$msg = 'Scanned palet not exist in palet table';
			    return view('Palets.error',compact('msg'));
		} else {

			$locations = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations ORDER BY id asc"));
			$locations = (object) $locations;
			// dd($locations);

			$selected_palet = $palet[0]->id;
			// dd($selected_palet);

			return view('Palets.choose_location', compact('locations','selected_palet'));

		}
		
	}

	public function update_location($selected_palet, Request $request) 
	{	
		$this->validate($request, ['location'=>'required']);
		$input = $request->all(); 

		$location = $input['location'];
		// dd($location);
		// dd($selected_palet);

		$locations = DB::connection('sqlsrv')->select(DB::raw("SELECT location_desc FROM locations WHERE location = '".$input['location']."'"));
		// $location_desc = $locations[0]->location_desc;
		// dd($location_desc);

		$table = palet::findOrFail($selected_palet);

		// try {		
			$table->location = $input['location'];
			$table->location_desc = $locations[0]->location_desc;
						
			$table->save();
		// }
		// catch (\Illuminate\Database\QueryException $e) {
		// 	return view('Palets.error');			
		// }
		
		return Redirect::to('/palets');
	}


}
