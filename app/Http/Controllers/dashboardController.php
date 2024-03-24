<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Target;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {
        $tahun = request()->input('tahun');
        $kelas = Target::select('kelas_id', DB::raw('ROUND(avg(target_persen)) as target'))->where('tahun', $tahun ? $tahun : date('Y'))->groupBy('kelas_id')->orderBy('kelas_id')->get();
        $kelasPersen = [];
        $kelasName = [];
        $key = 0;
        $targetName = [];
        $targetPersen = [];
        foreach ($kelas as $key => $item) {
            $targetPersen[] = [$item->target];
            $targetName[] = [$item->kelas->name];
            $kelasPersen[] = [$key + 1, $item->target];
            $kelasName[] = [$key + 1, $item->kelas->name];
        }
        $kelasName[] = [$key + 2 , 'test'];
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'kelasPersen' => $kelasPersen,
            'kelasName' => $kelasName,
            'targetName' => $targetName,
            'targetPersen' => $targetPersen,
        ]);
    }
}
