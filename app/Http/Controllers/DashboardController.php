<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Traits\DashboardChartTrait;

class DashboardController extends Controller
{
    use DashboardChartTrait;

    /**
     * AJAX endpoint untuk dashboard combined chart.
     */
    public function getChartData(): \Illuminate\Http\JsonResponse
    {
        $type  = request('type', 'imn');
        $tahun = (int) request('tahun', $this->getTahunPeriodeAktif());
        $unitId = request('unit_id');
        
        // Cek filter unit jika bukan admin/mutu
        $user = Auth::user();
        if (!in_array($user->role_id, [1, 2])) {
            $unitId = $user->unit_id;
        }

        return match ($type) {
            'imprs' => $this->allImprsChartData($tahun, $unitId),
            'unit'  => $this->allUnitChartData($tahun, $unitId),
            default => $this->allImnChartData($tahun, $unitId),
        };
    }

    public function index()
    {
        $user = Auth::user();
        $roleId = $user->role_id;

        // Tahun dari periode aktif — untuk default filter tahun di chart
        $periodeAktif = DB::table('tbl_periode')->where('status', 'aktif')->first();
        $tahunAktif   = $periodeAktif
            ? (int) \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->year
            : (int) date('Y');

        // Semua tahun yang pernah ada di tbl_periode, urutkan desc
        $daftarTahun = DB::table('tbl_periode')
            ->selectRaw('EXTRACT(YEAR FROM tanggal_mulai)::int AS tahun')
            ->groupByRaw('EXTRACT(YEAR FROM tanggal_mulai)')
            ->orderByRaw('EXTRACT(YEAR FROM tanggal_mulai) DESC')
            ->pluck('tahun')
            ->toArray();

        // Pastikan tahun aktif selalu ada di daftar
        if (!in_array($tahunAktif, $daftarTahun)) {
            array_unshift($daftarTahun, $tahunAktif);
        }

        $data = [
            'roleId' => $roleId,
            'pdsaList' => collect(),

            'totalIndikator' => DB::table('tbl_indikator')->count(),
            'years' => $this->getYears(),
            'tahunAktif'  => $tahunAktif,
            'daftarTahun' => $daftarTahun,
            'units'       => DB::table('tbl_unit')->orderBy('nama_unit')->get(),

            ...$this->getStatistikUnit(),
            ...$this->getRecentIsi(),
        ];

        $pdsaData = in_array($roleId, [1, 2])
            ? [
                'pdsaTotal' => $this->getTotalPdsa(),
                'pdsaList' => $this->getPdsaList()
            ]
            : [
                'pdsaTotal' => $this->getTotalPdsaAktif($user->unit_id),
                'pdsaList' => $this->getPdsaList($user->unit_id)
            ];

        $data['pdsaTotal'] = $pdsaData['pdsaTotal'];
        $data['pdsaList'] = $pdsaData['pdsaList'];

        if (in_array($roleId, [1, 2])) {
            // UnitIndikatorMap no longer used in combined-chart
        }

        return view('admin.dashboard', $data);
    }

    private function getIndikators()
    {
        return DB::table('tbl_indikator')
            ->leftJoin('tbl_kamus_indikator', 'tbl_kamus_indikator.id', '=', 'tbl_indikator.kamus_indikator_id')
            ->select(
                'tbl_indikator.id',
                'tbl_indikator.nama_indikator',
                'tbl_indikator.target_indikator',
                'tbl_indikator.unit_id',
                'tbl_kamus_indikator.periode_pengumpulan_data_id as periode_id'
            )
            ->get();
    }

    // deleted getUnitIndikatorMap

    private function getYears()
    {
        return DB::table('tbl_laporan_dan_analis')
            ->selectRaw('DISTINCT EXTRACT(YEAR FROM tanggal_laporan) as tahun')
            ->orderByDesc('tahun')
            ->pluck('tahun');
    }

    private function getStatistikUnit(): array
    {
        return Cache::remember('dashboard_statistik_unit', 1800, function () { // 30 mins
            $now = now();
            $bulanWajib = $now->copy()->subMonth()->month;
            $tahunWajib = $now->copy()->subMonth()->year;

            // Optimized: Fetch all stats in 2 queries and use collection mapping
            $totalTerisi = DB::table('tbl_laporan_dan_analis')
                ->whereMonth('tanggal_laporan', $bulanWajib)
                ->whereYear('tanggal_laporan', $tahunWajib)
                ->select('unit_id', 'indikator_id')
                ->get()
                ->groupBy('unit_id')
                ->map(fn($items) => $items->pluck('indikator_id')->unique()->flip());

            $units = DB::table('tbl_unit')->get();
            $indikatorsByUnit = DB::table('tbl_indikator')
                ->select('id', 'nama_indikator', 'unit_id')
                ->get()
                ->groupBy('unit_id');

            $unitsSudah = [];
            $unitsBelum = [];
            $totalIndikatorSudah = 0;
            $totalIndikatorBelum = 0;

            foreach ($units as $unit) {
                $inds = $indikatorsByUnit->get($unit->id);
                if (!$inds) continue;

                $sudah = [];
                $belum = [];
                $terisiIds = $totalTerisi->get($unit->id, collect());

                foreach ($inds as $ind) {
                    if ($terisiIds->has($ind->id)) {
                        $sudah[] = $ind->nama_indikator;
                        $totalIndikatorSudah++;
                    } else {
                        $belum[] = $ind->nama_indikator;
                        $totalIndikatorBelum++;
                    }
                }

                if (count($sudah) > 0) {
                    $unit->list_sudah = $sudah;
                    $unit->total_indikator = count($inds);
                    $unitsSudah[] = $unit;
                }

                if (count($belum) > 0) {
                    $uBelum = clone $unit;
                    $uBelum->list_belum = $belum;
                    $uBelum->list_sudah = $sudah;
                    $uBelum->total_indikator = count($inds);
                    $unitsBelum[] = $uBelum;
                }
            }

            return [
                'totalUnit' => count($units),
                'totalIndikatorSudah' => $totalIndikatorSudah,
                'totalIndikatorBelum' => $totalIndikatorBelum,
                'unitsSudah' => $unitsSudah,
                'unitsBelum' => $unitsBelum,
            ];
        });
    }

    private function getRecentIsi(): array
    {
        return [
            'recentIsi' => DB::table('tbl_laporan_dan_analis as l')
                ->join('tbl_unit as u', 'u.id', '=', 'l.unit_id')
                ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
                ->join('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
                ->where('ki.kategori_indikator', 'LIKE', '%Prioritas Unit%')
                ->orderByDesc('l.tanggal_laporan')
                ->limit(5)
                ->get()
        ];
    }

    // deleted getDivisionData and its heavy builder

    private function getTotalPdsaAktif($unitId = null)
    {
        $key = 'dashboard_total_pdsa_aktif_' . ($unitId ?? 'all');
        return Cache::remember($key, 3600, function () use ($unitId) { // 1 hour
            $query = DB::table('tbl_pdsa_assignments as p')
                ->whereIn('p.status_pdsa', ['assigned', 'submitted', 'revised', 'approved']);

            if ($unitId) {
                $query->where('p.unit_id', $unitId);
            }

            return $query->count();
        });
    }

    private function getTotalPdsa($unitId = null)
    {
        $key = 'dashboard_total_pdsa_' . ($unitId ?? 'all');
        return Cache::remember($key, 3600, function () use ($unitId) { // 1 hour
            // Optimized: Remove redundant join and simplify aggregate calculation
            $query = DB::table('tbl_laporan_dan_analis as l')
                ->join('tbl_indikator as i', 'l.indikator_id', '=', 'i.id')
                ->select(
                    'l.indikator_id',
                    'l.unit_id',
                    DB::raw('EXTRACT(YEAR FROM l.tanggal_laporan) as tahun'),
                    DB::raw("FLOOR((EXTRACT(MONTH FROM l.tanggal_laporan) - 1) / 3) + 1 as quarter_num")
                )
                ->groupBy(
                    'l.indikator_id',
                    'l.unit_id',
                    'i.target_indikator',
                    DB::raw('EXTRACT(YEAR FROM l.tanggal_laporan)'),
                    DB::raw("FLOOR((EXTRACT(MONTH FROM l.tanggal_laporan) - 1) / 3) + 1")
                )
                ->havingRaw('AVG(l.nilai) < i.target_indikator');

            if ($unitId) {
                $query->where('l.unit_id', $unitId);
            }

            return $query->get()->count();
        });
    }

    private function getPdsaList($unitId = null)
    {
        $key = 'dashboard_pdsa_list_' . ($unitId ?? 'all');
        return Cache::remember($key, 600, function () use ($unitId) { // 10 mins
            $query = DB::table('tbl_pdsa_assignments as p')
                ->join('tbl_unit', 'tbl_unit.id', '=', 'p.unit_id')
                ->join('tbl_indikator as i', 'i.id', '=', 'p.indikator_id')
                ->whereIn('p.status_pdsa', ['assigned', 'submitted', 'revised', 'approved']);

            if ($unitId) {
                $query->where('p.unit_id', $unitId);
            }

            return $query->select(
                'p.id',
                'p.status_pdsa',
                'i.nama_indikator',
                'p.unit_id',
                'p.created_at',
                'tbl_unit.nama_unit',
                'p.quarter',
                'p.tahun',
            )
                ->orderByDesc('p.created_at')
                ->limit(10)
                ->get();
        });
    }

    /**
     * Get detailed indicator data including monthly values, N/D, and PDSA status
     */
    public function getIndikatorDetail(Request $request, $id)
    {
        $tahun = (int) $request->input('tahun', $this->getTahunPeriodeAktif());

        // 1. Get Indicator Meta
        $indicator = DB::table('tbl_indikator as i')
            ->leftJoin('tbl_unit as u', 'u.id', '=', 'i.unit_id')
            ->leftJoin('tbl_kamus_indikator as ki', 'ki.id', '=', 'i.kamus_indikator_id')
            ->select('i.*', 'u.nama_unit', 'ki.kategori_indikator', 'ki.numerator as label_numerator', 'ki.denominator as label_denominator')
            ->where('i.id', $id)
            ->first();

        if (!$indicator) {
            return response()->json(['error' => 'Indicator not found'], 404);
        }

        // 2. Get Monthly Reports (Numerator, Denominator, Nilai)
        $reports = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $id)
            ->whereYear('tanggal_laporan', $tahun)
            ->selectRaw('
                EXTRACT(MONTH FROM tanggal_laporan) as bulan,
                SUM(numerator) as total_numerator,
                SUM(denominator) as total_denominator,
                AVG(nilai) as rata_nilai
            ')
            ->groupBy(DB::raw('EXTRACT(MONTH FROM tanggal_laporan)'))
            ->get()
            ->keyBy('bulan');

        $monthlyData = [];
        $hasil = array_fill(0, 12, null);
        
        foreach (range(1, 12) as $m) {
            $rep = $reports->get($m);
            $pencapaian = $rep ? round($rep->rata_nilai, 2) : 0;
            
            $monthlyData[] = [
                'bulan' => $m,
                'numerator' => $rep ? $rep->total_numerator : 0,
                'denominator' => $rep ? $rep->total_denominator : 0,
                'pencapaian' => $pencapaian,
            ];

            if ($rep) {
                $hasil[$m - 1] = $pencapaian;
            }
        }

        // 3. Get PDSA per Quarter (TW1 = Q1, TW2 = Q2, etc.)
        $pdsaAssignments = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->where('a.indikator_id', $id)
            ->where('a.tahun', $tahun)
            ->select('a.quarter', 'a.status_pdsa', 'p.plan', 'p.do', 'p.study', 'p.action')
            ->get()
            ->keyBy('quarter');

        $pdsaData = [];
        foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $idx => $q) {
            $assignment = $pdsaAssignments->get($q);
            $twName = $q;
            
            if (!$assignment) {
                $pdsaData[$twName] = [
                    'status' => 'Belum Ada',
                    'plan' => '-',
                    'do' => '-',
                    'study' => '-',
                    'action' => '-',
                    'color' => 'secondary'
                ];
            } else {
                $statusMap = [
                    'assigned' => ['label' => 'Perlu Diisi', 'color' => 'warning'],
                    'submitted' => ['label' => 'Menunggu Review', 'color' => 'info'],
                    'revised' => ['label' => 'Perlu Revisi', 'color' => 'danger'],
                    'approved' => ['label' => 'Disetujui', 'color' => 'success']
                ];
                
                $sd = $statusMap[$assignment->status_pdsa] ?? ['label' => 'Unknown', 'color' => 'dark'];
                
                $pdsaData[$twName] = [
                    'status' => $sd['label'],
                    'plan' => $assignment->plan ?? '',
                    'do' => $assignment->do ?? '',
                    'study' => $assignment->study ?? '',
                    'action' => $assignment->action ?? '',
                    'color' => $sd['color']
                ];
            }
        }

        return response()->json([
            'meta' => $indicator,
            'monthly' => $monthlyData,
            'hasil' => $hasil, // For re-rendering chart if needed
            'pdsa' => $pdsaData
        ]);
    }
}