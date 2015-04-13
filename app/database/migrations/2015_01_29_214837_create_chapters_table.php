<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChaptersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chapters', function(Blueprint $table)
		{
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('section');
            $table->tinyInteger('old')->default(0);

            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('section')->references('id')->on('sections')->onDelete('cascade');
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
		Schema::drop('chapters');
	}

}
