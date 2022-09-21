<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorsTable extends Migration {

	public function up()
	{
		Schema::create('vendors', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 150);
			$table->string('mobile', 150);
			$table->text('address');
			$table->string('email', 225);
			$table->tinyInteger('active');
			$table->integer('category_id');
			$table->string('logo', 255);
		});
	}

	public function down()
	{
		Schema::drop('vendors');
	}
}