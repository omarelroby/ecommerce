<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminsTable extends Migration {

	public function up()
	{
		Schema::create('admins', function(Blueprint $table) {
			$table->increments('id', true);
			$table->timestamps();
			$table->string('name', 150);
			$table->string('password', 100);
			$table->string('email', 200);
			$table->string('photo', 100);
		});
	}

	public function down()
	{
		Schema::drop('admins');
	}
}