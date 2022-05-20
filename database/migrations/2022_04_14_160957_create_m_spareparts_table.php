<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMSparepartsTable.
 */
class CreateMSparepartsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_spareparts', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('t_penerimaan_barangs_id')->unsigned();
			$table->string('nama');
			$table->string('kode_part');
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
		Schema::drop('m_spareparts');
	}
}
