<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TPerbaikanValidator.
 *
 * @package namespace App\Validators;
 */
class TPenerimaanValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nama_sparepart' => 'required|max:255',
            'kode_part' => 'required|max:255',
            'qty' => 'required|max:255',
            'tanggal_penerimaan' => 'required|max:255',
            'nama_supplier' => 'required|max:255',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
