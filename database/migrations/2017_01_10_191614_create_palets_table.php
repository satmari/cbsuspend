<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('palets', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('palet')->unique();
			$table->string('palet_barcode')->unique();

			$table->string('location')->nullable();
			$table->string('location_desc')->nullable();
						
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('palets');
	}

}
