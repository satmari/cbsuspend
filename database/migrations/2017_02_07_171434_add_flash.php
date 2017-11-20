<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlash extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		// Schema::table('cb_suspend', function($table)
		// {
  //   		$table->string('flash')->nullable();
		// });


		// Schema::table('cb_log', function($table)
		// {
  //   		$table->string('flash')->nullable();
		// });

		Schema::table('cb_suspend', function($table)
		{
    		$table->string('flag')->nullable();
		});


		Schema::table('cb_log', function($table)
		{
    		$table->string('flag')->nullable();
		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
