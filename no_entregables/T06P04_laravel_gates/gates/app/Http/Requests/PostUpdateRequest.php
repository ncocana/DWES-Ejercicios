<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'extract' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:16777215'],
            'expirable' => ['boolean'],
            'commentable' => ['boolean'],
            'access' => ['required', 'string', 'lowercase'],
        ];
    }
}
