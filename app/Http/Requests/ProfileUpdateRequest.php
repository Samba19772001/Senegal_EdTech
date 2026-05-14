<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nom'          => ['sometimes', 'string', 'max:100'],
            'prenom'       => ['sometimes', 'string', 'max:100'],
            'email'        => ['sometimes', 'string', 'email', 'max:191', Rule::unique(User::class)->ignore($this->user()->id)],
            'telephone'    => ['nullable', 'string', 'max:20'],
            'nom_ecole'    => ['sometimes', 'string', 'max:150'],
            'type_ecole'   => ['sometimes', 'in:publique,privee'],
            'region'       => ['sometimes', 'string', 'max:100'],
            'departement'  => ['nullable', 'string', 'max:100'],
            'commune'      => ['nullable', 'string', 'max:100'],
        ];
    }
}