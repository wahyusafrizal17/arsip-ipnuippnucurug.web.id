<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOutgoingLetterRequest extends FormRequest
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
            'klasifikasi' => ['required', 'string', Rule::in(array_keys(config('archive.klasifikasi', [])))],
            'indeks' => ['required', 'string', Rule::in(array_keys(config('archive.indeks', [])))],
            'tanggal_surat' => ['required', 'date'],
            'penerima' => ['required', 'string', 'max:255'],
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
            'tanggal_surat' => 'tanggal surat',
            'penerima' => 'penerima',
            'perihal' => 'perihal',
            'file_dokumen' => 'dokumen PDF',
        ];
    }
}
