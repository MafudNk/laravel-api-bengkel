<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTPenerimaanBarangsTable.
 */
class CreateTPenerimaanBarangsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_penerimaan_barangs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nama_supplier');
            $table->date('tanggal_penerimaan');	
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
		Schema::drop('t_penerimaan_barangs');
	}
}
