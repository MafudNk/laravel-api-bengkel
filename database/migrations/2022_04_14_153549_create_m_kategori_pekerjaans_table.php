<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMKategoriPekerjaansTable.
 */
class CreateMKategoriPekerjaansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_kategori_pekerjaans', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nama');
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
		Schema::drop('m_kategori_pekerjaans');
	}
}
