<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::where('username', $row['username_musyrif'])->first();
        if ($user) {
            $user_id = $user->id;
        } else {
            $user_id = null;
        }

        $siswa = Siswa::create([
            'name' => $row['nama'],
            'nis' => $row['nis'],
            'nisn' => $row['nisn'],
            'user_id' => $user_id,
        ]);

        return $siswa;
    }
}
