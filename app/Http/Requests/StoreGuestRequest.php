<?php

namespace App\Http\Requests;

use App\Models\Guest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class StoreGuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'nomor_hp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => ['required', 'email:rfc', 'max:100'],
            'instansi' => ['required', 'string', 'max:150'],
            'tujuan_kunjungan' => ['required', 'string', 'max:255'],
            'tanggal_kunjungan' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);

        // Sumber kunjungan tidak berasal dari input tamu, tetapi dari
        // URL yang dipakai tamu untuk membuka buku tamu.
        $data['sumber'] = $this->input('sumber', 'direct');

        if (! in_array($data['sumber'], Guest::SUMBER, true)) {
            $data['sumber'] = 'direct';
        }

        return $data;
    }
}
