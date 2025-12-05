<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'tournament_id'      => ['required', 'exists:tournaments,id'],
            'date'               => ['required', 'date'],
            'event_description'  => ['required', 'string', 'max:255'],
            'session_type_code'  => ['required', 'string', 'exists:session_types,code'],
            'courts_available'   => ['required', 'numeric'],
            'doors_open'         => ['required', 'date_format:H:i'],
            'start_time'         => ['required', 'date_format:H:i'],
            'end_time'           => ['required', 'date_format:H:i', 'after:start_time'],
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
            'tournament_id'      => "Turnamen",
            'date'               => "Tanggal",
            'event_description'  => "Deskripsi",
            'session_type_code'  => "Sesi",
            'courts_available'   => "Jumlah lapangan tersedia",
            'doors_open'         => "Waktu pintu dibuka",
            'start_time'         => "Waktu mulai",
            'end_time'           => "Waktu selesai",
        ];
    }
}
