<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMainCategoryTable extends Migration {

	public function up()
	{
		Schema::create('main_category', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 225);
			$table->string('translation_lang', 225);
			$table->string('translation_of', 50);
			$table->string('slug', 225);
			$table->string('photo', 225);
			$table->tinyInteger('active');

		});
	}

	public function down()
	{
		Schema::drop('main_category');
	}
}
