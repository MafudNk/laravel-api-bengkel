<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMMobilsTable.
 */
class CreateMMobilsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_mobils', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->string('nama');
			$table->string('no_chasis');
			$table->string('no_mesin');
			$table->string('no_pol');
			$table->string('merk_mobil');
			$table->string('tipe_mobil');
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
		Schema::drop('m_mobils');
	}
}
