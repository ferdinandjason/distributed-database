<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRestaurantsTable.
 */
class CreateRestaurantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nama');
			$table->string('username');
			$table->string('password');
			$table->string('alamat');
			$table->string('nomor_telepon');
			$table->rememberToken();
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
		Schema::drop('restaurants');
	}
}
