<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Customer.
 *
 * @package namespace App\Entities;
 */
class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_customer',
        'email',
        'alamat',
        'no_telp',
    ];

}
