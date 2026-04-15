<?php

namespace App\Http\Controllers\IndikatorMutu;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Storage;
use App\Services\IndikatorMutuService;

class ValidatorDataController extends Controller
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

        $availableMonths = $this->getAvailableValidationMonths($user);

        // Determine smart default month based on current time and period
        $now = now();
        $periodStart = Carbon::parse($periodeAktif->tanggal_mulai);
        $periodEnd = Carbon::parse($periodeAktif->tanggal_selesai);

        if ($now->between($periodStart, $periodEnd)) {
            $smartDefaultBulan = $now->month;
            $smartDefaultTahun = $now->year;
        } elseif ($now->lt($periodStart)) {
            $smartDefaultBulan = $periodStart->month;
            $smartDefaultTahun = $periodStart->year;
        } else {
            $smartDefaultBulan = $periodEnd->month;
            $smartDefaultTahun = $periodEnd->year;
        }

        if (!$request->has('bulan')) {
            if ($availableMonths->isNotEmpty()) {
                $firstAvailable = $availableMonths->first();
                $bulan = $firstAvailable->bulan;
                $tahun = $firstAvailable->tahun;
            } else {
                $bulan = $smartDefaultBulan;
                $tahun = $smartDefaultTahun;
            }
        } else {
            $bulan = (int) $request->bulan;
            $tahun = (int) $request->tahun;
        }
    

        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $kategoriIndikator = $request->filled('kategori_indikator')
            ? $request->kategori_indikator
            : null;
        $indikators = $this->indikatorService->getIndikator($user, $kategoriIndikator);
        
        // Filter: Hanya tampilkan indikator pada bulan masuknya (entry_date)
        $indikators = $indikators->filter(function($ind) use ($bulan, $tahun) {
            $entry = Carbon::parse($ind->entry_date);
            return $entry->month == $bulan && $entry->year == $tahun;
        });

        $indikatorIds = $indikators->pluck('id')->toArray();

        // Optimasi: Ambil semua tanggal laporan pertama untuk indikator-indikator ini dalam satu query
        $firstReports = DB::table('tbl_laporan_dan_analis')
            ->select('indikator_id', 'unit_id', DB::raw('MIN(tanggal_laporan) as first_report'))
            ->whereIn('indikator_id', $indikatorIds)
            ->whereBetween('tanggal_laporan', [
                Carbon::parse($periodeAktif->tanggal_mulai)->startOfMonth(),
                Carbon::parse($periodeAktif->tanggal_selesai)->endOfMonth()
            ])
            ->groupBy('indikator_id', 'unit_id')
            ->get()
            ->keyBy(fn($item) => $item->indikator_id . '-' . $item->unit_id);

        $periodeStart = Carbon::parse($periodeAktif->tanggal_mulai)->startOfMonth();
        $periodeEnd = Carbon::parse($periodeAktif->tanggal_selesai)->endOfMonth();
        $now = now()->startOfMonth();
        
        // Jika masih dalam periode, fallback ke bulan sekarang (dimaksimalkan ke awal periode)
        $defaultStart = ($now->gt($periodeEnd)) ? $periodeStart : $periodeStart->copy();

        $indikators = $indikators->filter(function ($ind) use ($bulan, $tahun, $firstReports, $defaultStart) {
            $key = $ind->id . '-' . $ind->unit_id;
            $firstReport = isset($firstReports[$key]) ? Carbon::parse($firstReports[$key]->first_report)->startOfMonth() : $defaultStart;
            
            return $firstReport->month == $bulan && $firstReport->year == $tahun;
        });

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

                $query = DB::table('tbl_laporan_validator')
                    ->select(
                        'id',
                        'tanggal_laporan',
                        'numerator',
                        'denominator',
                        'nilai_validator',
                        'indikator_id',
                        'unit_id',
                        'kategori_indikator',
                    )
                    ->where('indikator_id', $selectedIndikatorId)
                    ->whereBetween('tanggal_laporan', [$start, $end]);

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

        return view('menu.IndikatorMutu.laporan-validator.index', [
            'indikators' => $indikators,
            'rekapBulanan' => $rekapBulanan,
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'kategoriIndikatorList' => $kategoriIndikatorList,
            'kategoriIndikator' => $kategoriIndikator,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'availableMonths' => $availableMonths,
            'kalenderData' => $kalenderData,
            'selectedIndikator' => $selectedIndikator,
            'selectedIndikatorId' => $selectedIndikatorId,
            'selectedUnitId' => $selectedUnitId,
        ]);
    }



    private function getRekapBulanan($user, $bulan, $tahun, $kategoriIndikator = null)
    {
        $indikators = $this->indikatorService->getIndikator($user, $kategoriIndikator);

        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $query = DB::table('tbl_laporan_validator as l')
            ->join('tbl_indikator as i', 'i.id', '=', 'l.indikator_id')
            ->join('tbl_kamus_indikator as k', 'k.id', '=', 'i.kamus_indikator_id')
            ->whereBetween('l.tanggal_laporan', [$start, $end]);

        if ($kategoriIndikator) {
            $query->whereRaw("LOWER(k.kategori_indikator) LIKE ?", ['%' . strtolower($kategoriIndikator) . '%']);
        }

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('l.unit_id', $user->unit_id);
        }

        $rekap = $query
            ->select(
                'l.indikator_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai_validator),2) as nilai_rekap'),
                DB::raw('SUM(l.denominator) as denominator')
            )
            ->groupBy('l.indikator_id', 'l.unit_id')
            ->get()
            ->map(function ($item) use ($indikators) {
                $item->denominator = (int) $item->denominator;

                $indikator = $indikators->firstWhere('id', $item->indikator_id);

                if ($item->denominator === 0 || $item->nilai_rekap === null) {
                    $item->pencapaian = 'N/A';
                } elseif ($indikator) {
                    $item->pencapaian = $this->indikatorService->hitungPencapaian(
                        $item->nilai_rekap,
                        $indikator->arah_target,
                        $indikator->target_indikator,
                        $indikator->target_min,
                        $indikator->target_max
                    ) ? 'tercapai' : 'tidak-tercapai';
                } else {
                    $item->pencapaian = 'tidak-tercapai';
                }

                return $item;
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
            'tanggal_laporan' => 'required|date',
            'indikator_id' => 'required',
            'unit_id' => 'required',
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:0',
            'file_laporan' => 'nullable|file|mimes:xlsx,xls,pdf',
        ]);

        DB::beginTransaction();

        try {
            $periodeAktif = $this->indikatorService->getPeriodeAktif();

            if (!$periodeAktif) {
                return back()->with('error', 'Periode aktif tidak ditemukan');
            }

            $tanggal = Carbon::parse($request->tanggal_laporan);

            $resultDeadline = $this->validasiDeadline(
                $periodeAktif,
                $tanggal,
                $request->unit_id
            );

            if ($resultDeadline !== true) {
                return back()->with(
                    'error',
                    'Data tidak bisa diinput karena melewati batas deadline tanggal '
                    . $resultDeadline->format('d M Y H:i')
                );
            }

            $validationMonth = $this->getBulanValidasi(
                $request->indikator_id,
                $request->unit_id,
                $periodeAktif
            );

            if ($tanggal->month != $validationMonth->month || $tanggal->year != $validationMonth->year) {
                return back()->with(
                    'error',
                    'Validator hanya boleh diisi pada bulan validasi (' . $validationMonth->translatedFormat('F Y') . ')'
                );
            }

            $start = $validationMonth->copy()->startOfMonth();
            $end = $validationMonth->copy()->endOfMonth();

            // Pastikan ada minimal 1 data analis di bulan pertama
            $laporanAnalisId = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->value('id');

            if (!$laporanAnalisId) {
                return back()->with('error', 'Data analis bulan pertama belum tersedia');
            }

            // Hitung nilai validator: jika 0/0 maka N/A (tidak ada kasus)
            if ($request->numerator == 0 && $request->denominator == 0) {
                $nilaiValidator = null;
                $pencapaian = 'N/A';
            } else {
                $nilaiValidator = ($request->denominator > 0)
                    ? ($request->numerator / $request->denominator) * 100
                    : 0;

                $tercapai = $this->indikatorService->hitungPencapaian(
                    $nilaiValidator,
                    $indikatorFull->arah_target,
                    $indikatorFull->target_indikator,
                    $indikatorFull->target_min,
                    $indikatorFull->target_max
                );

                $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';
            }

            // Simpan file jika ada
            $filePath = null;
            if ($request->hasFile('file_laporan')) {
                $filePath = $request->file('file_laporan')->store('laporan_indikator', 'public');
            }

            // Insert validator baru
            DB::table('tbl_laporan_validator')->insert([
                'laporan_analis_id' => $laporanAnalisId,
                'tanggal_laporan' => $request->tanggal_laporan,
                'indikator_id' => $request->indikator_id,
                'unit_id' => $request->unit_id,
                'numerator' => $request->numerator,
                'denominator' => $request->denominator,
                'nilai_validator' => $nilaiValidator !== null ? round($nilaiValidator, 2) : null,
                'pencapaian' => $pencapaian,
                'status_laporan' => null,
                'file_laporan' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Hitung ulang rata-rata validator bulan pertama (null/N/A diabaikan SQL AVG)
            $rataValidator = DB::table('tbl_laporan_validator')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->avg('nilai_validator');

            $rataValidator = $rataValidator !== null ? round($rataValidator, 2) : null;

            // Ambil rata-rata nilai analis bulan pertama sebagai acuan status validasi
            $rataAnalis = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->avg('nilai');

            $rataAnalis = $rataAnalis !== null ? round($rataAnalis, 2) : null;

            // Hitung status validasi: valid jika rata analis >= 90% dari rata validator
            $statusFinal = $this->indikatorService->hitungStatusValidasi($rataAnalis, $rataValidator);

            // Update SEMUA row analis bulan pertama agar nilai_validator konsisten di halaman analis
            DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $request->indikator_id)
                ->where('unit_id', $request->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->update([
                    'nilai_validator' => $rataValidator,
                    'status_laporan' => $statusFinal,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return back()->with('success', 'Validator berhasil disimpan');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $data = DB::table('tbl_laporan_validator')
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
            'nilai_validator' => $data->nilai_validator ?? 0,
            'pencapaian' => $data->pencapaian ?? null,
            'tanggal_laporan' => $data->tanggal_laporan ?? null,
            'file_laporan' => $data->file_laporan ?? null,
            'status_laporan' => $data->status_laporan ?? null,
        ]);
    }


    public function show($id)
    {
        $data = DB::table('tbl_laporan_validator')
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('tbl_laporan_validator')->where('id', $id)->first();

        if (!$data) {
            return back()->with('error', 'Data laporan tidak ditemukan');
        }

        $indikatorFull = DB::table('tbl_indikator')
            ->where('id', $data->indikator_id)
            ->first();

        if (!$indikatorFull) {
            return back()->with('error', 'Indikator tidak ditemukan');
        }

        $request->validate([
            'numerator' => 'required|numeric|min:0|lte:denominator',
            'denominator' => 'required|numeric|min:0',
            'file_laporan' => 'nullable|file|mimes:xlsx,xls,pdf|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $data = DB::table('tbl_laporan_validator')->where('id', $id)->first();

            if (!$data) {
                return back()->with('error', 'Data laporan tidak ditemukan');
            }

            $periodeAktif = $this->indikatorService->getPeriodeAktif();

            if (!$periodeAktif) {
                return back()->with('error', 'Periode aktif tidak ditemukan');
            }

            $tanggalValidator = Carbon::parse($data->tanggal_laporan);

            $resultDeadline = $this->validasiDeadline(
                $periodeAktif,
                $tanggalValidator,
                $data->unit_id
            );

            if ($resultDeadline !== true) {
                return back()->with(
                    'error',
                    'Data tidak bisa diubah karena melewati batas deadline tanggal '
                    . $resultDeadline->format('d M Y H:i')
                );
            }

            $validationMonth = $this->getBulanValidasi(
                $data->indikator_id,
                $data->unit_id,
                $periodeAktif
            );

            if ($tanggalValidator->month != $validationMonth->month || $tanggalValidator->year != $validationMonth->year) {
                return back()->with(
                    'error',
                    'Validator hanya boleh diubah pada bulan validasi (' . $validationMonth->translatedFormat('F') . ')'
                );
            }

            $start = $validationMonth->copy()->startOfMonth();
            $end = $validationMonth->copy()->endOfMonth();

            // Hitung nilai validator: jika 0/0 maka N/A (tidak ada kasus)
            if ($request->numerator == 0 && $request->denominator == 0) {
                $nilaiValidator = null;
                $pencapaian = 'N/A';
            } else {
                $nilaiValidator = ($request->denominator > 0)
                    ? ($request->numerator / $request->denominator) * 100
                    : 0;

                $tercapai = $this->indikatorService->hitungPencapaian(
                    $nilaiValidator,
                    $indikatorFull->arah_target,
                    $indikatorFull->target_indikator,
                    $indikatorFull->target_min,
                    $indikatorFull->target_max
                );

                $pencapaian = $tercapai ? 'tercapai' : 'tidak-tercapai';
            }

            $updateData = [
                'numerator' => $request->numerator,
                'denominator' => $request->denominator,
                'nilai_validator' => $nilaiValidator !== null ? round($nilaiValidator, 2) : null,
                'pencapaian' => $pencapaian,
                'status_laporan' => null,
                'updated_at' => now(),
            ];

            if ($request->hasFile('file_laporan')) {
                if ($data->file_laporan) {
                    Storage::disk('public')->delete($data->file_laporan);
                }

                $updateData['file_laporan'] =
                    $request->file('file_laporan')->store('laporan_indikator', 'public');
            }

            DB::table('tbl_laporan_validator')->where('id', $id)->update($updateData);

            // Hitung ulang rata-rata validator bulan pertama (null/N/A diabaikan SQL AVG)
            $rataValidator = DB::table('tbl_laporan_validator')
                ->where('indikator_id', $data->indikator_id)
                ->where('unit_id', $data->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->avg('nilai_validator');

            $rataValidator = $rataValidator !== null ? round($rataValidator, 2) : null;

            // Ambil rata-rata nilai analis bulan pertama sebagai acuan status validasi
            $rataAnalis = DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $data->indikator_id)
                ->where('unit_id', $data->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->avg('nilai');

            $rataAnalis = $rataAnalis !== null ? round($rataAnalis, 2) : null;

            // Hitung status validasi: valid jika rata analis >= 90% dari rata validator
            $statusFinal = $this->indikatorService->hitungStatusValidasi($rataAnalis, $rataValidator);

            // Update SEMUA row analis bulan pertama agar nilai_validator konsisten di halaman analis
            DB::table('tbl_laporan_dan_analis')
                ->where('indikator_id', $data->indikator_id)
                ->where('unit_id', $data->unit_id)
                ->whereBetween('tanggal_laporan', [$start, $end])
                ->update([
                    'nilai_validator' => $rataValidator,
                    'status_laporan' => $statusFinal,
                    'updated_at' => now(),
                ]);

            DB::commit();

            return back()->with('success', 'Validator berhasil diperbarui');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    private function getAvailableValidationMonths($user)
    {
        $periode = $this->indikatorService->getPeriodeAktif();
        if (!$periode) return collect();

        $start = Carbon::parse($periode->tanggal_mulai)->startOfMonth();
        $end = Carbon::parse($periode->tanggal_selesai)->endOfMonth();
        $now = now()->startOfMonth();

        // Cari tanggal laporan paling awal untuk unit ini
        $earliestReport = DB::table('tbl_laporan_dan_analis')
            ->whereBetween('tanggal_laporan', [$start, $end]);

        if (!in_array($user->unit_id, [1, 2])) {
            $earliestReport->where('unit_id', $user->unit_id);
        }

        $earliestDate = $earliestReport->min('tanggal_laporan');

        // Logical Start Date: Yang lebih awal antara laporan pertama atau hari ini
        $nowStart = $now->copy()->startOfMonth();
        if ($nowStart->gt($end)) {
            // Jika masa sekarang sudah melewati periode, tampilkan dari awal periode (Januari)
            $effectiveStart = $start->copy();
        } else {
            // Jika dalam/sebelum periode, gunakan hari ini (clamped ke awal periode)
            $effectiveStart = $start->copy();
        }

        if ($earliestDate) {
            $eDate = Carbon::parse($earliestDate)->startOfMonth();
            if ($eDate->lt($effectiveStart)) {
                $effectiveStart = $eDate;
            }
        }

        // Buat list berkelanjutan dari effectiveStart sampai akhir periode
        $months = collect();
        $current = $effectiveStart->copy();
        while ($current->lte($end)) {
            $months->push((object)[
                'bulan' => $current->month,
                'tahun' => $current->year,
                'nama' => $current->translatedFormat('F')
            ]);
            $current->addMonth();
        }

        return $months;
    }

    private function getBulanValidasi($indikatorId, $unitId, $periodeAktif)
    {
        return $this->indikatorService->getBulanValidasi($indikatorId, $unitId, $periodeAktif);
    }

    private function validasiDeadline($periodeAktif, $tanggal, $unitId)
    {
        if ($periodeAktif->status_deadline != 1) {
            return true;
        }

        $unitException = $periodeAktif->unit_exception
            ? json_decode($periodeAktif->unit_exception, true)
            : [];

        if (in_array($unitId, $unitException)) {
            return true;
        }

        $deadline = (int) $periodeAktif->deadline;

        $batasPengisian = $tanggal
            ->copy()
            ->addMonth()
            ->day(min($deadline, $tanggal->copy()->addMonth()->daysInMonth))
            ->endOfDay();

        if (now()->gt($batasPengisian)) {
            return $batasPengisian;
        }

        return true;
    }
}