<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('abbr', 50);
			$table->string('locale', 50);
			$table->string('name', 150);
			$table->string('direction', 50);
			$table->tinyInteger('active');
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}