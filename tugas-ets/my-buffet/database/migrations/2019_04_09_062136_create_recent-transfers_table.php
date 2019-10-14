<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRecentTransfersTable.
 */
class CreateRecentTransfersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recent_transfers', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('order_id')->unsigned();
			$table->bigInteger('total');
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
		Schema::drop('recent-transfers');
	}
}
