<?php

declare(strict_types=1);

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;

final class RegisterValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }
}
