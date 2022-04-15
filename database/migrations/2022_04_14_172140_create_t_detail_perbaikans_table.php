<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTDetailPerbaikansTable.
 */
class CreateTDetailPerbaikansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_detail_perbaikans', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('perbaikan_id')->unsigned();
			$table->integer('sparepart_id')->unsigned();
			$table->integer('qty');
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
		Schema::drop('t_detail_perbaikans');
	}
}
