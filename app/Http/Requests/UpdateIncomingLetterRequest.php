<?php

namespace App\Http\Requests;

use App\Support\KlasifikasiOptions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIncomingLetterRequest extends FormRequest
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
            'klasifikasi' => ['required', 'string', Rule::in(KlasifikasiOptions::keysForUser($this->user()))],
            'indeks' => ['required', 'string', Rule::in(array_keys(config('archive.indeks', [])))],
            'tanggal_surat' => ['required', 'date'],
            'tanggal_penerimaan' => ['required', 'date'],
            'pengirim' => ['required', 'string', 'max:255'],
            'perihal' => ['required', 'string'],
            'file_dokumen' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
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
            'klasifikasi' => 'klasifikasi',
            'indeks' => 'indeks',
            'tanggal_surat' => 'tanggal surat',
            'tanggal_penerimaan' => 'tanggal penerimaan surat',
            'pengirim' => 'pengirim',
            'perihal' => 'perihal',
            'file_dokumen' => 'dokumen PDF',
            'organization' => 'organisasi',
        ];
    }
}
