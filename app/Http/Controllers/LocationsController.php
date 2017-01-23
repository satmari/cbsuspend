<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\location;
use DB;

class LocationsController extends Controller {

	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM locations ORDER BY location asc"));
		return view('Locations.index', compact('data'));
	}

	public function add_new_location()
	{
		return view('Locations.add');
	}

	public function location_insert(Request $request)
	{
		//validation
		$this->validate($request, ['location'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$location = $input['location'];
		$location_desc = $input['location_desc'];

		// dd($location);
		// Record 
		try {
			$table = new location;

			$table->location = $location;
			$table->location_desc = $location_desc;

			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save location in table";
			return view('Locations.error',compact('msg'));
		}

		return Redirect::to('/locations');
	}

	public function edit_location($id)
	{
		$data = location::findOrFail($id);		
		return view('Locations.edit', compact('data'));

	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['location_desc'=>'required']);

		$table = location::findOrFail($id);		
		
		$input = $request->all(); 
		//dd($input);

		try {		
			// $table->location = $input['location'];
			$table->location_desc = $input['location_desc'];
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('Locations.error');			
		}
		
		return Redirect::to('/locations');
	}
	
}
