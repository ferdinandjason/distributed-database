<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class RestaurantValidator.
 *
 * @package namespace App\Validators;
 */
class RestaurantValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'nama' => 'string|required',
            'username' => 'string|required|unique:restaurants',
            'password' => 'required|between:6,255|confirmed',
            'alamat' => 'string|required',
            'nomor_telepon' => 'string|required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
