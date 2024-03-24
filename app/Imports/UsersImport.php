<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user =  new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'telepon' => $row['telepon'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
        ]);
        $user->save();
        $user->assignRole('admin');
        return $user;
    }
}
