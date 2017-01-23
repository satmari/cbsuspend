<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\sticker;
use DB;

class StickersController extends Controller {

	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM stickers ORDER BY sticker"));
		return view('Stickers.index', compact('data'));
	}

	public function add_new_sticker()
	{
		return view('Stickers.add');
	}

	public function sticker_insert(Request $request)
	{
		//validation
		$this->validate($request, ['sticker'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$sticker = $input['sticker'];
		$sticker_desc = $input['sticker_desc'];
		$sticker_color = $input['color'][0];

		// dd($color);
		// Record 
		try {
			$table = new sticker;

			$table->sticker = $sticker;
			$table->sticker_desc = $sticker_desc;
			$table->sticker_color = $sticker_color;

			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save sticker in table";
			return view('Stickers.error',compact('msg'));
		}

		return Redirect::to('/stickers');
	}

	public function edit_sticker($id)
	{
		$data = sticker::findOrFail($id);		
		return view('Stickers.edit', compact('data'));

	}

	public function update($id, Request $request) {
		//
		$this->validate($request, ['sticker_desc'=>'required']);

		$table = sticker::findOrFail($id);
		
		$input = $request->all(); 
		//dd($input);

		// dd($input['sticker_color']);

		try {		
			// $table->sticker = $input['sticker'];
			$table->sticker_desc = $input['sticker_desc'];
			// $table->sticker_color = $input['sticker_color'][0];
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('Stickers.error');			
		}
		
		return Redirect::to('/stickers');
	}

}
