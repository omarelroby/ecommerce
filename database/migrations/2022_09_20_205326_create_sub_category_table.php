<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubCategoryTable extends Migration {

	public function up()
	{
		Schema::create('sub_category', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->increments('parent_id');
			$table->string('name', 150);
			$table->string('slug', 150);
			$table->string('photo', 150);
			$table->tinyInteger('active');
			$table->increments('category_id');
		});
	}

	public function down()
	{
		Schema::drop('sub_category');
	}
}