<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nama_barang' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'integer', 'min:0'],
            'status_barang' => ['required', Rule::in(['baik', 'rusak', 'hilang'])],
            'lokasi_penyimpanan' => ['required', 'string', 'max:255'],
        ];

        if ($this->user()?->isAdmin()) {
            $rules['organization'] = ['required', Rule::in(array_keys(config('archive.letter_organizations', [])))];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama_barang' => 'nama barang',
            'jumlah' => 'jumlah',
            'status_barang' => 'status barang',
            'lokasi_penyimpanan' => 'lokasi penyimpanan',
            'organization' => 'organisasi',
        ];
    }
}
