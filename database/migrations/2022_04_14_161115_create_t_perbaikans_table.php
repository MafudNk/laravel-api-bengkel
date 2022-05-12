<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTPerbaikansTable.
 */
class CreateTPerbaikansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_perbaikans', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('mobil_id')->unsigned();
			$table->date('estimasi_selesai');
			$table->date('tanggal_masuk')->nullable();
			$table->date('tanggal_selesai')->nullable();
			$table->string('status');
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
		Schema::drop('t_perbaikans');
	}
}
