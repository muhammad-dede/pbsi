<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tournament_id' => ['required', 'exists:tournaments,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'rate_single' => ['required', 'numeric'],
            'rate_double' => ['required', 'numeric'],
            'rate_twin' => ['required', 'numeric'],
            'currency_code' => ['required', 'size:3', 'exists:currencies,code'],
            'facilities' => ['required', 'string'],
            'breakfast_included' => ['required', 'boolean'],
            'breakfast_persons' => ['required', 'numeric'],
            'is_official' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'tournament_id'      => 'Turnamen',
            'name'               => 'Nama',
            'address'            => 'Alamat',
            'rate_single'        => 'Tarif Single',
            'rate_double'        => 'Tarif Double',
            'rate_twin'          => 'Tarif Twin',
            'currency_code'      => 'Mata Uang',
            'facilities'         => 'Fasilitas',
            'breakfast_included' => 'Termasuk Sarapan',
            'breakfast_persons'  => 'Jumlah Orang Sarapan',
            'is_official'        => 'Resmi',
        ];
    }
}
