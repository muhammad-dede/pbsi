<?php

namespace App\Http\Requests\Tournament;

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
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'prize_money' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_address' => ['required', 'string'],
            'organizer' => ['required', 'string', 'max:255'],
            'organizer_address' => ['required', 'string'],
            'sanction' => ['required', 'string', 'max:255'],
            'official_shuttlecock' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
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
            'name' => 'Nama',
            'title' => 'Title',
            'prize_money' => 'Uang Hadiah',
            'currency' => 'Mata Uang',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'venue_name' => 'Nama Tempat',
            'venue_address' => 'Alamat Tempat',
            'organizer' => 'Penyelenggara',
            'organizer_address' => 'Alamat Penyelenggara',
            'sanction' => 'Sanction',
            'official_shuttlecock' => 'Official Shuttlecock',
            'status' => 'Status',
        ];
    }
}
