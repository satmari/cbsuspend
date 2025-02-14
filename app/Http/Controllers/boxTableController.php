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

class boxTableController extends Controller {

	public function index()
	{
		//
		Session::set('cb_to_add_array', null);
		Session::set('cb_to_remove_array', null);
		Session::set('sticker_array', null);
		Session::set('location', null);
		Session::set('coment', null);
		
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT cb.*,
					(SELECT palet FROM palets WHERE id = cb.palet_id) as palet,
					(SELECT location FROM palets WHERE id = cb.palet_id) as location
			FROM cb_suspend as cb ORDER BY palet_id asc"));
		return view('Table.index', compact('data'));
	}

	public function index_log()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT l.*,
					(SELECT palet FROM palets WHERE id = l.palet_id) as palet,
					(SELECT location FROM palets WHERE id = l.palet_id) as location
			FROM cb_log as l ORDER BY unblock_date asc"));
		return view('Table.index_log', compact('data'));
	}

	// Change Coment
	public function edit_coment($id)
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM cb_suspend WHERE id = '".$id."'"));
		$data = (object) $data[0];

		// dd($data);

		return view('Table.set_coment', compact('data'));
	}

	public function update_coment($id, Request $request)
	{
		// Validate
		// $this->validate($request, ['newcoment' => 'required']);
		$input = $request->all();

		// dd($input['newcoment']);

		if (isset($input['newcoment'])) {
			
			$table = cbSuspend::findOrFail($id);
		
			try {		
				$table->coment = $input['newcoment'];
				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg = "Problem to change coment in table";
				return view('Table.error',compact('msg'));
			}
			
		} else {

			$table = cbSuspend::findOrFail($id);
		
			try {		
				$table->coment = "";
				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg = "Problem to change coment in table";
				return view('Table.error',compact('msg'));
			}
			
		}

		if (isset($input['newreason'])) {
			
			$table = cbSuspend::findOrFail($id);
		
			try {		
				$table->reason = $input['newreason'];
				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg = "Problem to change reason in table";
				return view('Table.error',compact('msg'));
			}
			
		} else {

			$table = cbSuspend::findOrFail($id);
		
			try {		
				$table->reason = "";
				$table->save();
			}
			catch (\Illuminate\Database\QueryException $e) {
				$msg = "Problem to change reason in table";
				return view('Table.error',compact('msg'));
			}
			
		}

		return Redirect::to('/');
		
	}

	public function export() 
	{
		$list = cbSuspend::all();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(\Schema::getColumnListing('cb_suspend'));

        foreach ($list as $line) {
            $csv->insertOne($line->toArray());
        }

        $csv->output('cbSuspend.csv');
	}

}
