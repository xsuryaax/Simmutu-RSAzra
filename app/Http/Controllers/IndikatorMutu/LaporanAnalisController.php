<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Services\IndikatorMutuService;

class LaporanAnalisController extends Controller
{
    protected $indikatorService;

    public function __construct(IndikatorMutuService $indikatorService)
    {
        $this->indikatorService = $indikatorService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $periodeAktif = $this->indikatorService->getPeriodeAktif();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        $periodStart = Carbon::parse($periodeAktif->tanggal_mulai);
        $periodEnd = Carbon::parse($periodeAktif->tanggal_selesai);
        $now = now();

        // Cari tanggal laporan paling awal untuk unit ini di periode aktif
        $earliestReport = DB::table('tbl_laporan_dan_analis')
            ->whereBetween('tanggal_laporan', [$periodStart->startOfMonth(), $periodEnd->endOfMonth()]);
        
        if (!in_array($user->unit_id, [1, 2])) {
            $earliestReport->where('unit_id', $user->unit_id);
        }
        
        $earliestDate = $earliestReport->min('tanggal_laporan');
        
        // Logical Start Date: Yang lebih awal antara laporan pertama atau hari ini
        $nowStart = $now->copy()->startOfMonth();
        if ($nowStart->gt($periodEnd)) {
            // Jika masa sekarang sudah melewati periode, tampilkan dari awal periode
            $effectiveStart = $periodStart->copy();
        } else {
            // Jika dalam/sebelum periode, gunakan hari ini (clamped ke awal periode)
            $effectiveStart = $nowStart->max($periodStart);
        }

        if ($earliestDate) {
            $eDate = Carbon::parse($earliestDate)->startOfMonth();
            if ($eDate->lt($effectiveStart)) {
                $effectiveStart = $eDate;
            }
        }
    

        if (!$request->has('bulan')) {
            if ($now->between($periodStart, $periodEnd)) {
                $bulan = $now->month;
                $tahun = $now->year;
            } elseif ($now->lt($periodStart)) {
                $bulan = $periodStart->month;
                $tahun = $periodStart->year;
            } else {
                // Jika sudah lewat periode, default ke bulan efektif pertama (Januari jika ada data/awal)
                $bulan = $effectiveStart->month;
                $tahun = $effectiveStart->year;
            }
        } else {
            $bulan = (int)$request->bulan;
            $tahun = (int)$request->tahun;
        }

        $kategoriIndikator = $request->filled('kategori_indikator')
            ? $request->kategori_indikator
            : null;

        $indikators = $this->indikatorService->getIndikator($user, $kategoriIndikator);
        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator);

        $kategoriIndikatorList = DB::table('tbl_kamus_indikator')
            ->select('kategori_indikator')
            ->whereNotNull('kategori_indikator')
            ->distinct()
            ->orderBy('kategori_indikator')
            ->pluck('kategori_indikator');

        $selectedIndikatorId = $request->indikator_id;
        $selectedUnitId = $request->unit_id;

        if (!$selectedIndikatorId && $indikators->isNotEmpty()) {
            $firstIndikator = $indikators->first();
            $selectedIndikatorId = $firstIndikator->id;
            $selectedUnitId = $firstIndikator->unit_id;
        }

        $kalenderData = null;
        $selectedIndikator = null;

        if ($selectedIndikatorId) {

            $selectedIndikator = $indikators->firstWhere('id', $selectedIndikatorId);

            if ($selectedIndikator) {

                $query = DB::table('tbl_laporan_dan_analis')
                    ->select(
                        'id',
                        'tanggal_laporan',
                        'numerator',
                        'denominator',
                        'nilai',
                        'indikator_id',
                        'unit_id',
                        'kategori_indikator',
                        'nilai_validator',
                        'status_laporan',
                    )
                    ->where('indikator_id', $selectedIndikatorId)
                    ->whereMonth('tanggal_laporan', $bulan)
                    ->whereYear('tanggal_laporan', $tahun);

                if ($selectedUnitId) {
                    $query->where('unit_id', $selectedUnitId);
                }

                $dataPengisian = $query->get()
                    ->keyBy(function ($item) {
                        return Carbon::parse($item->tanggal_laporan)->format('Y-m-d');
                    });

                $startOfMonth = Carbon::create($tahun, $bulan, 1);

                $kalenderData = [
                    'daysInMonth' => $startOfMonth->daysInMonth,
                    'skip' => $startOfMonth->dayOfWeekIso - 1,
                    'dataPengisian' => $dataPengisian,
                    'bulanNama' => $startOfMonth->translatedFormat('F'),
                ];
            }
        }

        return view('menu.IndikatorMutu.laporan-analis.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'kategoriIndikatorList' => $kategoriIndikatorList,
            'kategoriIndikator' => $kategoriIndikator,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kalenderData' => $kalenderData,
            'selectedIndikator' => $selectedIndikator,
            'selectedIndikatorId' => $selectedIndikatorId,
            'selectedUnitId' => $selectedUnitId,
            'effectiveStart' => $effectiveStart,
        ]);
    }


    private function getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator = null)
    {
        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $query = DB::table('tbl_laporan_dan_analis as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->whereBetween('l.tanggal_laporan', [$start, $end])
            ->where('i.status_indikator', 'aktif');

        if ($kategoriIndikator) {
            $query->whereRaw("LOWER(l.kategori_indikator) LIKE ?", ['%' . strtolower($kategoriIndikator) . '%']);
        }

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('l.unit_id', $user->unit_id);
        }

        $results = $query
            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai),2) as nilai_rekap'),
                DB::raw('ROUND(AVG(l.nilai_validator),2) as nilai_validator'),
                DB::raw('MAX(l.status_laporan) as status_laporan'),
                DB::raw('SUM(l.denominator) as denominator')
            )
            ->groupBy('l.indikator_id', 'l.unit_id')
            ->get();

        $indikatorIds = $results->pluck('indikator_id')->unique()->toArray();
        $periode = $this->indikatorService->getPeriodeAktif();

        // Optimasi: Ambil semua tanggal laporan pertama untuk indikator-indikator ini dalam satu query
        $firstReports = DB::table('tbl_laporan_dan_analis')
            ->select('indikator_id', 'unit_id', DB::raw('MIN(tanggal_laporan) as first_report'))
            ->whereIn('indikator_id', $indikatorIds)
            ->whereBetween('tanggal_laporan', [
                Carbon::parse($periode->tanggal_mulai)->startOfMonth(),
                Carbon::parse($periode->tanggal_selesai)->endOfMonth()
            ])
            ->groupBy('indikator_id', 'unit_id')
            ->get()
            ->keyBy(fn($item) => $item->indikator_id . '-' . $item->unit_id);

        $periodeStart = Carbon::parse($periode->tanggal_mulai)->startOfMonth();
        $periodeEnd = Carbon::parse($periode->tanggal_selesai)->endOfMonth();
        $now = now()->startOfMonth();
        $defaultStart = $now->max($periodeStart)->min($periodeEnd);

        $rekap = $results->map(function ($r) use ($firstReports, $defaultStart) {
                $r->denominator = (int) $r->denominator;

                // Ambil info bulan validasi untuk ditampilkan di view
                $key = $r->indikator_id . '-' . $r->unit_id;
                $vMonth = isset($firstReports[$key]) 
                    ? Carbon::parse($firstReports[$key]->first_report)->startOfMonth() 
                    : $defaultStart;

                $r->validation_month_name = $vMonth->translatedFormat('F Y');
                $r->validation_month = $vMonth->month;
                $r->validation_year = $vMonth->year;
                
                return $r;
            })
            ->keyBy(fn($r) => $r->indikator_id . '-' . $r->unit_id);

        return $rekap;
    }

    public function store(Request $request)
    {
        $indikatorFull = DB::table('tbl_indikator')
            ->where('id', $request->indikator_id)
            ->first();

        if (!$indikatorFull) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $request->validate([
            'indikator_id' => 'required|exists:tbl_indikator,id',
            'tanggal_laporan' => 'required|date',
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:0',
            'file_laporan' => 'nullable|file|max:5120',
            'unit_id' => 'sometimes|exists:tbl_unit,id',
        ]);

        if ($request->denominator == 0 && $request->numerator > 0) {
            return back()->with('error', 'Jika denominator 0 maka numerator harus 0');
        }

        $periode = $this->indikatorService->getPeriodeAktif();
        if (!$periode) {
            return back()->with('error', 'Periode mutu aktif belum tersedia');
        }

        $tanggalLaporan = Carbon::parse($request->tanggal_laporan)->startOfDay();
        $now = now()->startOfDay();

        if ($tanggalLaporan->gt($now)) {
            return back()->with('error', 'Tidak boleh menginput laporan melebihi tanggal hari ini');
        }

        $periodeMulai = Carbon::parse($periode->tanggal_mulai)->startOfDay();
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai)->endOfDay();

        if ($tanggalLaporan->lt($periodeMulai) || $tanggalLaporan->gt($periodeSelesai)) {
            return back()->with('error', 'Tanggal laporan harus berada dalam periode mutu aktif');
        }

        $unitId = $request->unit_id ?? auth()->user()->unit_id;

        if (!$this->bolehInputLaporan($periode, $tanggalLaporan, $unitId)) {
            return back()->with('error', 'Batas waktu pengisian laporan telah lewat');
        }

        $indikator = DB::table('tbl_indikator as i')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->where('i.id', $request->indikator_id)
            ->select('k.kategori_indikator', 'k.kategori_id')
            ->first();

        if (!$indikator) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $kategoriLower = strtolower($indikator->kategori_indikator);

        if (
            str_contains($kategoriLower, 'prioritas unit') ||
            str_contains($kategoriLower, 'prioritas rs')
        ) {
            $request->validate([
                'unit_id' => 'required|exists:tbl_unit,id',
            ]);
        }

        // Hitung nilai: jika 0/0 maka N/A (tidak ada kasus)
        if ($request->numerator == 0 && $request->denominator == 0) {
            $nilai = null;
            $pencapaian = 'N/A';
        } else {
            $nilai = ($request->denominator > 0)
                ? ($request->numerator / $request->denominator) * 100
                : 0;

            $tercapai = $this->indikatorService->hitungPencapaian(
                $nilai,
                $indikatorFull->arah_target,
                $indikatorFull->target_indikator,
                $indikatorFull->target_min,
                $indikatorFull->target_max
            );

            $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';
        }

        $nilaiRounded = $nilai !== null ? round($nilai, 2) : null;

        $exists = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->whereDate('tanggal_laporan', $tanggalLaporan)
            ->when(
                str_contains($kategoriLower, 'prioritas unit') ||
                str_contains($kategoriLower, 'prioritas rs'),
                fn($q) => $q->where('unit_id', $request->unit_id)
            )
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data laporan untuk tanggal tersebut sudah ada');
        }

        $rataValidator = $this->getRataValidator(
            $request->indikator_id,
            $unitId
        );

        // Insert row baru dulu dengan status sementara null
        DB::table('tbl_laporan_dan_analis')->insert([
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id ?? null,
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => $nilaiRounded,
            'nilai_validator' => $rataValidator,
            'status_laporan' => null,
            'target_saat_input' => $indikatorFull->target_indikator,
            'target_min_saat_input' => $indikatorFull->target_min,
            'target_max_saat_input' => $indikatorFull->target_max,
            'arah_target_saat_input' => $indikatorFull->arah_target,
            'pencapaian' => $pencapaian,
            'tanggal_laporan' => $request->tanggal_laporan,
            'file_laporan' => $request->hasFile('file_laporan')
                ? $request->file('file_laporan')->store('laporan_indikator', 'public')
                : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hitung rata-rata semua nilai analis di bulan ini (termasuk yang baru diinsert)
        $bulanLaporan = $tanggalLaporan->month;
        $tahunLaporan = $tanggalLaporan->year;
        $startBulan = Carbon::create($tahunLaporan, $bulanLaporan, 1)->startOfMonth();
        $endBulan = Carbon::create($tahunLaporan, $bulanLaporan, 1)->endOfMonth();

        $rataAnalis = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$startBulan, $endBulan])
            ->avg('nilai');

        $rataAnalis = $rataAnalis !== null ? round($rataAnalis, 2) : null;

        // Hitung status berdasarkan rata-rata semua analis bulan ini vs validator
        $statusFinal = $this->indikatorService->hitungStatusValidasi($rataAnalis, $rataValidator);

        // Update status dan nilai_validator ke SEMUA row di bulan ini agar konsisten
        DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $request->indikator_id)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$startBulan, $endBulan])
            ->update([
                'nilai_validator' => $rataValidator,
                'status_laporan' => $statusFinal,
                'updated_at' => now(),
            ]);

        return redirect()->route('laporan-analis.index', [
            'bulan' => $bulanLaporan,
            'tahun' => $tahunLaporan,
            'kategori_indikator' => $request->kategori_indikator,
            'indikator_id' => $request->indikator_id,
            'unit_id' => $request->unit_id,
        ])->with('success', 'Data laporan berhasil disimpan');
    }

    public function getDetail($id)
    {
        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $data->id,
            'indikator_id' => $data->indikator_id ?? null,
            'tanggal_pengisian' => $data->created_at,
            'unit_id' => $data->unit_id ?? null,
            'numerator' => $data->numerator ?? 0,
            'denominator' => $data->denominator ?? 0,
            'nilai' => $data->nilai,
            'pencapaian' => $data->pencapaian ?? null,
            'tanggal_laporan' => $data->tanggal_laporan ?? null,
            'file_laporan' => $data->file_laporan ?? null,
            'status_laporan' => $data->status_laporan ?? null,
            'kategori_indikator' => $data->kategori_indikator ?? null,
        ]);
    }

    public function show($id)
    {
        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return back()->with('error', 'Data laporan tidak ditemukan');
        }

        $indikatorFull = DB::table('tbl_indikator')
            ->where('id', $data->indikator_id)
            ->first();

        $request->validate([
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:0',
            'file_laporan' => 'nullable|file|max:5120',
        ]);

        if ($request->denominator == 0 && $request->numerator > 0) {
            return back()->with('error', 'Jika denominator 0 maka numerator harus 0');
        }

        $periode = $this->indikatorService->getPeriodeAktif();

        $tanggalLaporan = Carbon::parse($data->tanggal_laporan)->startOfDay();

        $periodeMulai = Carbon::parse($periode->tanggal_mulai)->startOfDay();
        $periodeSelesai = Carbon::parse($periode->tanggal_selesai)->endOfDay();

        if ($tanggalLaporan->lt($periodeMulai) || $tanggalLaporan->gt($periodeSelesai)) {
            return back()->with('error', 'Tanggal laporan berada di luar periode mutu aktif');
        }

        if ($tanggalLaporan->gt(now()->startOfDay())) {
            return back()->with('error', 'Tidak boleh mengubah laporan ke tanggal masa depan');
        }

        $unitId = $data->unit_id ?? auth()->user()->unit_id;

        if (!$this->bolehInputLaporan($periode, $tanggalLaporan, $unitId)) {
            return back()->with('error', 'Batas waktu pengisian laporan telah lewat');
        }

        // Hitung nilai: jika 0/0 maka N/A (tidak ada kasus)
        if ($request->numerator == 0 && $request->denominator == 0) {
            $nilai = null;
            $pencapaian = 'N/A';
        } else {
            $nilai = ($request->denominator > 0)
                ? ($request->numerator / $request->denominator) * 100
                : 0;

            $tercapai = $this->indikatorService->hitungPencapaian(
                $nilai,
                $indikatorFull->arah_target,
                $indikatorFull->target_indikator,
                $indikatorFull->target_min,
                $indikatorFull->target_max
            );

            $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';
        }

        $nilaiRounded = $nilai !== null ? round($nilai, 2) : null;

        $updateData = [
            'numerator' => $request->numerator,
            'denominator' => $request->denominator,
            'nilai' => $nilaiRounded,
            'pencapaian' => $pencapaian,
            'updated_at' => now(),
        ];

        if ($request->hasFile('file_laporan')) {
            if ($data->file_laporan) {
                Storage::disk('public')->delete($data->file_laporan);
            }

            $updateData['file_laporan'] = $request
                ->file('file_laporan')
                ->store('laporan_indikator', 'public');
        }

        // Update row yang diedit dulu
        DB::table('tbl_laporan_dan_analis')
            ->where('id', $id)
            ->update($updateData);

        // Hitung ulang rata-rata semua nilai analis di bulan yang sama (termasuk yang baru diupdate)
        $bulanLaporan = $tanggalLaporan->month;
        $tahunLaporan = $tanggalLaporan->year;
        $startBulan = Carbon::create($tahunLaporan, $bulanLaporan, 1)->startOfMonth();
        $endBulan = Carbon::create($tahunLaporan, $bulanLaporan, 1)->endOfMonth();

        $rataAnalis = DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $data->indikator_id)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$startBulan, $endBulan])
            ->avg('nilai');

        $rataAnalis = $rataAnalis !== null ? round($rataAnalis, 2) : null;

        $rataValidator = $this->getRataValidator(
            $data->indikator_id,
            $unitId
        );

        // Hitung status berdasarkan rata-rata semua analis bulan ini vs validator
        $statusFinal = $this->indikatorService->hitungStatusValidasi($rataAnalis, $rataValidator);

        // Update nilai_validator dan status ke SEMUA row di bulan ini agar konsisten
        DB::table('tbl_laporan_dan_analis')
            ->where('indikator_id', $data->indikator_id)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$startBulan, $endBulan])
            ->update([
                'nilai_validator' => $rataValidator,
                'status_laporan' => $statusFinal,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Data laporan berhasil diperbarui');
    }

    private function getRataValidator($indikatorId, $unitId)
    {
        $periode = $this->indikatorService->getPeriodeAktif();
        $validationMonth = $this->indikatorService->getBulanValidasi($indikatorId, $unitId, $periode);

        $start = $validationMonth->copy()->startOfMonth();
        $end = $validationMonth->copy()->endOfMonth();

        $rata = DB::table('tbl_laporan_validator')
            ->where('indikator_id', $indikatorId)
            ->where('unit_id', $unitId)
            ->whereBetween('tanggal_laporan', [$start, $end])
            ->avg('nilai_validator');

        return $rata !== null ? round($rata, 2) : null;
    }

    private function bolehInputLaporan($periode, $tanggalLaporan, $unitId)
    {
        if (!$periode->status_deadline) {
            return true;
        }

        $deadline = (int) $periode->deadline;

        $batasPengisian = Carbon::parse($tanggalLaporan)
            ->copy()
            ->addMonth()
            ->day(min(
                $deadline,
                Carbon::parse($tanggalLaporan)->copy()->addMonth()->daysInMonth
            ))
            ->endOfDay();

        $isException = DB::table('tbl_periode_unit_deadline')
            ->where('periode_id', $periode->id)
            ->where('unit_id', $unitId)
            ->exists();

        if ($isException) {
            return true;
        }

        return now()->lte($batasPengisian);
    }
}