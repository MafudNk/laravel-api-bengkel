<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMSuppliersTable.
 */
class CreateMSuppliersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_suppliers', function(Blueprint $table) {
            $table->increments('id');
			$table->string('nama');
			$table->string('alamat');
			$table->string('nama_pic');
			$table->string('no_telp_pic');
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
		Schema::drop('m_suppliers');
	}
}
