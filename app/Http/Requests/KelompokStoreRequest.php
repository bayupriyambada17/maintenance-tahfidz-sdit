<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelompokStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'guru_id' => 'required',
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id',
            'tahun_pelajaran_id' => 'required',
            'kategori' => 'required'
        ];
    }
}
