<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MobilValidator.
 *
 * @package namespace App\Validators;
 */
class MobilValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nama' => 'required|max:255',
            'no_chasis' => 'required|max:255',
            'no_mesin' => 'required|max:255',
            'no_pol' => 'required|max:255',
            'merk_mobil' => 'required|max:255',
            'tipe_mobil' => 'required|max:255',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'nama' => 'required|max:255',
            'no_chasis' => 'required|max:255',
            'no_mesin' => 'required|max:255',
            'no_pol' => 'required|max:255',
            'merk_mobil' => 'required|max:255',
            'tipe_mobil' => 'required|max:255',
        ],
    ];
}
