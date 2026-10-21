<?php

namespace App\Http\Requests\tugas;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatedTugas extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'nama_tugas' => ['sometimes', 'required', 'string', 'max:255'],
            'link_tugas' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
