<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBindsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('binds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('id_user');
            $table->unsignedInteger('id_section');
			$table->unsignedInteger('id_article');

            $table->tinyinteger('read')->default(0);
            $table->integer('time')->default(0);
			$table->tinyinteger('special_article')->default(0);

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_section')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('id_article')->references('id')->on('articles')->onDelete('cascade');

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
		Schema::drop('binds');
	}

}
