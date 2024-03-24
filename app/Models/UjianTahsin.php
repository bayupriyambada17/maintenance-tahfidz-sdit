<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianTahsin extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public static function indexUjian()
    {
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');
        $siswa = request()->input('siswa');
        $kelas = request()->input('kelas');
        $surat = request()->input('surat');
        if (auth()->user()->hasRole('admin')) {
            $data = UjianTahsin::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                                return $query->whereBetween('tanggal', [$mulai, $akhir]);
                            })
                            ->when($siswa, function ($query) use ($siswa) {
                                return $query->whereHas('siswa', function ($query) use ($siswa) {
                                                $query->where('name', 'LIKE', '%'.$siswa.'%');
                                            });
                            })
                            ->when($kelas, function ($query) use ($kelas) {
                                return $query->whereHas('kelas', function ($query) use ($kelas) {
                                                $query->where('name', 'LIKE', '%'.$kelas.'%');
                                            });
                            })
                            ->when($surat, function ($query) use ($surat) {
                                return $query->where('from', 'LIKE', '%'.$surat.'%')
                                             ->orWhere('to', 'LIKE', '%'.$surat.'%');
                                            
                            })
                            ->orderBy('id', 'ASC');
        } else {
            $data = UjianTahsin::where('user_id', auth()->user()->id)
                            ->when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                                return $query->whereBetween('tanggal', [$mulai, $akhir]);
                            })
                            ->when($siswa, function ($query) use ($siswa) {
                                return $query->whereHas('siswa', function ($query) use ($siswa) {
                                                $query->where('name', 'LIKE', '%'.$siswa.'%');
                                            });
                            })
                            ->when($kelas, function ($query) use ($kelas) {
                                return $query->whereHas('kelas', function ($query) use ($kelas) {
                                                $query->where('name', 'LIKE', '%'.$kelas.'%');
                                            });
                            })
                            ->when($surat, function ($query) use ($surat) {
                                return $query->where('from', 'LIKE', '%'.$surat.'%')
                                             ->orWhere('to', 'LIKE', '%'.$surat.'%');
                            })
                            ->orderBy('id', 'ASC');
        }

        return $data;
    }
}
