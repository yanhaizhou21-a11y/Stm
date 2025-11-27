<?php

namespace App\Http\Requests\Pengembalian;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePengembalianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peminjaman_id' => ['required', 'exists:peminjaman,id'],
            'status_barang' => ['required', Rule::in(['dikembalikan', 'rusak', 'hilang'])],
            'tanggal_dikembalikan' => ['required', 'date_format:Y-m-d\TH:i'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
