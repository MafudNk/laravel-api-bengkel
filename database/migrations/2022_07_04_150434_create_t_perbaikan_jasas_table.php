<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTPerbaikanJasasTable.
 */
class CreateTPerbaikanJasasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_perbaikan_jasas', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('t_perbaikans_id')->unsigned();
            $table->string('nama_jasa');
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
		Schema::drop('t_perbaikan_jasas');
	}
}
