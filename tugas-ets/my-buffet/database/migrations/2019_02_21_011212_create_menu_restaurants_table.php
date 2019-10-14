<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMenuRestaurantsTable.
 */
class CreateMenuRestaurantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_restaurants', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('restaurant_id')->unsigned();
			$table->string('nama_makanan');
			$table->longText('deskripsi');
			$table->string('kategori');
			$table->bigInteger('harga');
			$table->string('foto');
			$table->integer('stok');
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
		Schema::drop('menu_restaurants');
	}
}
