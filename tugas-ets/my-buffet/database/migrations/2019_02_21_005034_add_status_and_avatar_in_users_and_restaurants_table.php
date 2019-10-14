<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndAvatarInUsersAndRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default('user.jpg');
            $table->string('status')->default('user');
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('avatar')->default('restaurant.jpg');
            $table->string('status')->default('restaurant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar','status']);
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn(['avatar','status']);
        });
    }
}
