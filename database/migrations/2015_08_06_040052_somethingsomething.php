<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Somethingsomething extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaign_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('campaign_id');
			$table->string('users_id');
			$table->timestamps();
		});


		Schema::table('social', function(Blueprint $table)
		{
			$table->string('token');
			$table->integer('users_id');
		});

		Schema::drop('campaign_social');
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
