<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianTahfidz extends Model
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

    public function from()
    {
        return $this->belongsTo(Surat::class, 'from_surat');
    }

    public function to()
    {
        return $this->belongsTo(Surat::class, 'to_surat');
    }

    public static function indexUjian()
    {
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');
        $siswa = request()->input('siswa');
        $kelas = request()->input('kelas');
        $surat = request()->input('surat');
        if (auth()->user()->hasRole('admin')) {
            $data = UjianTahfidz::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                                return $query->whereBetween('tanggal', [$mulai, $akhir]);
                            })
                            ->when($siswa, function ($query) use ($siswa) {
                                return $query->whereHas('siswa', function ($query) use ($siswa) {
                                                $query->where('name', 'LIKE', '%'.$siswa.'%');
                                            });
                            })
                            ->when($kelas, function ($query) use ($kelas) {
                                return $query->whereHas('target', function ($query) use ($kelas) {
                                                $query->whereHas('kelas', function ($query) use ($kelas) {
                                                    $query->where('name', 'LIKE', '%'.$kelas.'%');
                                                });
                                            });
                            })
                            ->when($surat, function ($query) use ($surat) {
                                return $query->whereHas('from', function ($query) use ($surat) {
                                                $query->where('name', 'LIKE', '%'.$surat.'%');
                                            })
                                            ->orWhereHas('to', function ($query) use ($surat) {
                                                $query->where('name', 'LIKE', '%'.$surat.'%');
                                            });
                            })
                            ->orderBy('id', 'ASC');
        } else {
            $data = UjianTahfidz::where('user_id', auth()->user()->id)
                            ->when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                                return $query->whereBetween('tanggal', [$mulai, $akhir]);
                            })
                            ->when($siswa, function ($query) use ($siswa) {
                                return $query->whereHas('siswa', function ($query) use ($siswa) {
                                                $query->where('name', 'LIKE', '%'.$siswa.'%');
                                            });
                            })
                            ->when($kelas, function ($query) use ($kelas) {
                                return $query->whereHas('target', function ($query) use ($kelas) {
                                                $query->whereHas('kelas', function ($query) use ($kelas) {
                                                    $query->where('name', 'LIKE', '%'.$kelas.'%');
                                                });
                                            });
                            })
                            ->when($surat, function ($query) use ($surat) {
                                return $query->whereHas('from', function ($query) use ($surat) {
                                                $query->where('name', 'LIKE', '%'.$surat.'%');
                                            })
                                            ->orWhereHas('to', function ($query) use ($surat) {
                                                $query->where('name', 'LIKE', '%'.$surat.'%');
                                            });
                            })
                            ->orderBy('id', 'ASC');
        }

        return $data;
    }
}
