<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CustomerValidator.
 *
 * @package namespace App\Validators;
 */
class CustomerValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nama_customer' => 'required|max:255',
            'email' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'alamat' => 'required|max:255',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'id' => 'required',
            'nama_customer' => 'required|max:255',
            'email' => 'required|max:255',
            'no_telp' => 'required|max:255',
            'alamat' => 'required|max:255',
        ],
    ];
}
