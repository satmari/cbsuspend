<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbSuspendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cb_suspend', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('cartonbox')->unique();
			$table->dateTime('cartonbox_date');
			$table->string('po', 24);
			$table->string('style', 12);
			$table->string('color', 12);
			$table->string('colordesc', 64);
			$table->string('size', 8);

			$table->string('sku')->nullable();

			$table->dateTime('po_due_date');

			$table->integer('qty')->nullable();

			$table->string('sticker', 24)->nullable();
			$table->string('sticker_color')->nullable();
			$table->string('location', 32)->nullable();
			$table->integer('palet_id')->nullable();

			$table->string('status', 64);

			$table->dateTime('block_date')->nullable();
			$table->dateTime('unblock_date')->nullable();

			$table->string('coment', 64)->nullable();
			$table->string('reason', 64)->nullable();

			// $table->string('flash')->nullable();
			// $table->string('flag')->nullable();
			// $table->string('po_status')->nullable();
			
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
		Schema::drop('cb_suspend');
	}

}
