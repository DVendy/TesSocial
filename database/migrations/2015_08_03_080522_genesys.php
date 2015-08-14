<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Genesys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
			$table->string('social_id');
			$table->timestamps();
		});

		Schema::create('campaign_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('campaign_id');
			$table->string('users_id');
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
		//
	}

}
