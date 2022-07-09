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
            'sparepart_id' => 'required',
            'kode_part' => 'required|max:255',
            'qty' => 'required|max:255',
            'tanggal_penerimaan' => 'required|max:255',
            'supplier_id' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
