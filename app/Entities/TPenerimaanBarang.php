<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TPenerimaanBarang.
 *
 * @package namespace App\Entities;
 */
class TPenerimaanBarang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'm_sparepart_id',
        'm_supplier_id',
        'kode_part',
        'qty',
        'tanggal_penerimaan'
    ];
}
