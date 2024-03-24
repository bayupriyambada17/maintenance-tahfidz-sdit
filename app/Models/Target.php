<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function total($juz) 
    {
        $surat = Surat::where('juz', $juz)->get();
        $sum_ayat = 0;

        foreach ($surat as $s) {
            $total_ayat = $s->last_ayat - $s->first_ayat + 1;
            $sum_ayat += $total_ayat;
        }
        
        return $sum_ayat;
    }
}
