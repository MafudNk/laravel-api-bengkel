<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MMobil.
 *
 * @package namespace App\Entities;
 */
class MMobil extends Model
{
    use HasFactory;
    protected $table = 'm_mobils';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',  'customers_id', 'no_chasis', 'no_mesin', 'no_pol', 'merk_mobil', 'tipe_mobil', 'asuransi'
    ];
}
