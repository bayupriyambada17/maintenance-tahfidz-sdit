<?php

namespace App\Imports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SuratImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $surat = Surat::create([
            'name' => $row['nama'],
            'first_ayat' => $row['ayat_pertama'],
            'last_ayat' => $row['ayat_kedua'],
            'juz' => $row['juz'],
            'order' => $row['urutan_surat'],
        ]);

        return $surat;
    }
}
