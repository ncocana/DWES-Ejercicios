<?php

namespace App\Http\Requests;

use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Profile2UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Get the user's ID
        $profileId = $this->user()->HasOneProfile->id;

        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Profile::class)->ignore($profileId),
            ],
            'alias' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
