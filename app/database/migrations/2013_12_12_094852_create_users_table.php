<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Creating user table
		Schema::create("users",function($table){

 			$table->increments('id');
			$table->string("email")->unique();
			$table->string("name");
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
		//Droping scheme table
		Schema::drop("users");
	}

}