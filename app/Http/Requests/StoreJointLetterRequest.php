<?php

namespace App\Http\Requests;

use App\Support\KlasifikasiOptions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJointLetterRequest extends FormRequest
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
        return [
            'klasifikasi' => ['required', 'string', Rule::in(KlasifikasiOptions::keysForUser($this->user()))],
            'indeks' => ['required', 'string', Rule::in(array_keys(config('archive.indeks', [])))],
            'nomor_surat' => ['required', 'string', 'max:128'],
            'tanggal_surat' => ['required', 'date'],
            'pengirim' => ['required', 'string', 'max:255'],
            'perihal' => ['required', 'string'],
            'file_dokumen' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'klasifikasi' => 'klasifikasi',
            'indeks' => 'indeks',
            'nomor_surat' => 'nomor surat',
            'tanggal_surat' => 'tanggal surat',
            'pengirim' => 'pengirim',
            'perihal' => 'perihal',
            'file_dokumen' => 'dokumen PDF',
        ];
    }
}
