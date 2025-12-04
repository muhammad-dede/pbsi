<?php

namespace App\Http\Requests\Event;

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
            'event_category_code' => ['required', 'exists:event_categories,code'],
            'main_draw_size' => ['required', 'integer'],
            'qualifying_positions' => ['nullable', 'integer'],
            'max_qualifying_entries' => ['nullable', 'integer'],
            'prize_distributions' => ['nullable', 'array'],
            'prize_distributions.*.round_code' => ['required_with:prize_distributions', 'string', 'exists:rounds,code'],
            'prize_distributions.*.amount' => ['required_with:prize_distributions', 'numeric'],
            'prize_distributions.*.is_per_pair' => ['required_with:prize_distributions', 'boolean'],
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
            'tournament_id' => 'Turnamen',
            'event_category_code' => 'Kategori',
            'main_draw_size' => 'Ukuran Undian Utama',
            'qualifying_positions' => 'Posisi Kualifikasi',
            'max_qualifying_entries' => 'Entri Kualifikasi Maksimum',
            'prize_distributions' => 'Distribusi Hadiah',
            'prize_distributions.*.round_code' => 'Round',
            'prize_distributions.*.amount' => 'Jumlah',
            'prize_distributions.*.is_per_pair' => 'Per Pasangan',
        ];
    }
}
