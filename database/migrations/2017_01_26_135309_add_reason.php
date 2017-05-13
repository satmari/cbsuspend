<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReason extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		//
		/*
		Schema::table('cb_suspend', function($table)
		{
    		$table->string('reason')->nullable();
		});


		Schema::table('cb_log', function($table)
		{
    		$table->string('reason')->nullable();
		});
		*/
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
