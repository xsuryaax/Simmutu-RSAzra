<?php

namespace App\Http\Controllers\Spm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\SpmLaporanAnalis;
use Carbon\Carbon;

class LaporanSpmController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $periodeAktif = DB::table('tbl_periode')->where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Periode mutu aktif belum disetting');
        }

        $periodStart = Carbon::parse($periodeAktif->tanggal_mulai);
        $periodEnd = Carbon::parse($periodeAktif->tanggal_selesai);
        $now = now();

        $effectiveStart = $periodStart->copy();

        if (!$request->has('bulan')) {
            // Default to current month if within period, otherwise start of period
            if ($now->between($periodStart, $periodEnd)) {
                $bulan = $now->month;
                $tahun = $now->year;
            } elseif ($now->lt($periodStart)) {
                $bulan = $periodStart->month;
                $tahun = $periodStart->year;
            } else {
                $bulan = $periodEnd->month;
                $tahun = $periodEnd->year;
            }
        } else {
            $bulan = (int)$request->bulan;
            $tahun = (int)$request->tahun;
        }

        $kategoriSpm = null;

        $spmsQuery = DB::table('tbl_spm')
            ->leftJoin('tbl_unit', 'tbl_unit.id', '=', 'tbl_spm.unit_id')
            ->join('tbl_spm_periode', function ($join) use ($periodeAktif) {
                $join->on('tbl_spm.id', '=', 'tbl_spm_periode.spm_id')
                     ->where('tbl_spm_periode.periode_id', $periodeAktif->id)
                     ->where('tbl_spm_periode.status', 'aktif');
            })
            ->select('tbl_spm.*', 'tbl_unit.nama_unit')
            ->where('tbl_spm.status_spm', 'aktif');
        if (!in_array($user->unit_id, [1, 2])) {
            $spmsQuery->where('tbl_spm.unit_id', $user->unit_id);
        }
        $spms = $spmsQuery->get();

        $rekapBulanan = $this->getRekapBulanan($user, $bulan, $tahun);

        $kategoriSpmList = collect([]);

        $selectedSpmId = $request->spm_id;
        $selectedUnitId = $request->unit_id;

        if (!$selectedSpmId && $spms->isNotEmpty()) {
            $selectedSpmId = $spms->first()->id;
        }
        if (!$selectedUnitId && $spms->isNotEmpty()) {
            $selectedUnitId = $spms->first()->unit_id;
        }

        $selectedSpm = $spms->firstWhere('id', $selectedSpmId);

        if (!$selectedSpm && $spms->isEmpty()) {
            $selectedSpmId = -1;
            $selectedSpm = (object)[
                'nama_spm' => 'Belum ada SPM',
                'nama_unit' => '-'
            ];
        }

        $kalenderData = [];
        if ($selectedSpmId) {
            $dataPengisian = DB::table('tbl_spm_laporan_dan_analis')
                ->where('spm_id', $selectedSpmId)
                ->where('unit_id', $selectedUnitId)
                ->whereYear('tanggal_laporan', $tahun)
                ->whereMonth('tanggal_laporan', $bulan)
                ->get()
                ->keyBy(fn($item) => Carbon::parse($item->tanggal_laporan)->format('Y-m-d'));

            $startOfMonth = Carbon::create($tahun, $bulan, 1);

            $kalenderData = [
                'daysInMonth' => $startOfMonth->daysInMonth,
                'skip' => $startOfMonth->dayOfWeekIso - 1,
                'dataPengisian' => $dataPengisian,
                'bulanNama' => $startOfMonth->translatedFormat('F'),
            ];
        }

        return view('menu.spm.laporan-spm.index', [
            'spms' => $spms,
            'rekapBulanan' => $rekapBulanan,
            'periodeAktif' => $periodeAktif,
            'periode' => $periodeAktif,
            'kategoriSpmList' => $kategoriSpmList,
            'kategoriSpm' => $kategoriSpm,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kalenderData' => $kalenderData,
            'laporanData' => $kalenderData, // Adding alias just in case
            'selectedSpm' => $selectedSpm,
            'selectedSpmId' => $selectedSpmId,
            'selectedUnitId' => $selectedUnitId,
            'effectiveStart' => $effectiveStart,
        ]);
    }

    private function getRekapBulanan($user, $bulan, $tahun)
    {
        $start = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $query = DB::table('tbl_spm_laporan_dan_analis as l')
            ->join('tbl_spm as i', 'i.id', '=', 'l.spm_id')
            ->whereBetween('l.tanggal_laporan', [$start, $end])
            ->where('i.status_spm', 'aktif');

        if (!in_array($user->unit_id, [1, 2])) {
            $query->where('l.unit_id', $user->unit_id);
        }

        $results = $query
            ->select(
                'l.spm_id',
                'l.unit_id',
                DB::raw('ROUND(AVG(l.nilai),2) as nilai_rekap'),
                DB::raw('SUM(l.denominator) as denominator')
            )
            ->groupBy('l.spm_id', 'l.unit_id')
            ->get();

        $defaultStart = $start;

        return $results->map(function ($r) use ($defaultStart) {
                $r->denominator = (int) $r->denominator;
                $r->validation_month_name = $defaultStart->translatedFormat('F Y');
                $r->validation_month = $defaultStart->month;
                $r->validation_year = $defaultStart->year;
                return $r;
            })
            ->keyBy(fn($r) => $r->spm_id . '-' . $r->unit_id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'spm_id' => 'required',
            'unit_id' => 'required',
            'tanggal_laporan' => 'required|date',
            'numerator' => 'required|numeric|lte:denominator',
            'denominator' => 'required|numeric',
        ], [
            'numerator.lte' => 'Numerator tidak boleh lebih besar dari Denominator'
        ]);

        $tanggal = Carbon::parse($request->tanggal_laporan);
        
        $spm = DB::table('tbl_spm')->where('id', $request->spm_id)->first();
        if (!$spm) return back()->with('error', 'SPM tidak ditemukan');

        $nilai = ($request->denominator > 0) ? ($request->numerator / $request->denominator) * 100 : null;
        
        $pencapaian = 'N/A';
        if ($nilai !== null) {
            $pencapaian = 'tidak-tercapai';
            if ($spm->arah_target == 'lebih_besar' && $nilai >= $spm->target_spm) $pencapaian = 'tercapai';
            elseif ($spm->arah_target == 'lebih_kecil' && $nilai <= $spm->target_spm) $pencapaian = 'tercapai';
            elseif ($spm->arah_target == 'range' && $nilai >= $spm->target_min && $nilai <= $spm->target_max) $pencapaian = 'tercapai';
        }

        $laporanPath = null;
        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $laporanPath = $file->storeAs('laporan_spm', $filename, 'public');
        }

        SpmLaporanAnalis::updateOrCreate(
            [
                'spm_id' => $request->spm_id,
                'unit_id' => $request->unit_id,
                'tanggal_laporan' => $tanggal->format('Y-m-d')
            ],
            [
                'numerator' => $request->numerator,
                'denominator' => $request->denominator,
                'nilai' => $nilai !== null ? round($nilai, 2) : null,
                'pencapaian' => $pencapaian,
                'file_laporan' => $laporanPath,
                'target_saat_input' => $spm->target_spm,
                'target_min_saat_input' => $spm->target_min,
                'target_max_saat_input' => $spm->target_max,
                'arah_target_saat_input' => $spm->arah_target,
            ]
        );

        return redirect()->back()->with('success', 'Data SPM berhasil disimpan');
    }

    public function detail($id)
    {
        $data = DB::table('tbl_spm_laporan_dan_analis')->where('id', $id)->first();
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        return response()->json([
            'id' => $data->id,
            'tanggal_pengisian' => $data->updated_at,
            'tanggal_laporan' => $data->tanggal_laporan,
            'numerator' => (float)$data->numerator,
            'denominator' => (float)$data->denominator,
            'nilai' => $data->nilai,
            'pencapaian' => $data->pencapaian,
            'file_laporan' => $data->file_laporan
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numerator' => 'required|numeric|lte:denominator',
            'denominator' => 'required|numeric',
        ], [
            'numerator.lte' => 'Numerator tidak boleh lebih besar dari Denominator'
        ]);

        $laporan = SpmLaporanAnalis::findOrFail($id);
        $spm = DB::table('tbl_spm')->where('id', $laporan->spm_id)->first();

        $nilai = ($request->denominator > 0) ? ($request->numerator / $request->denominator) * 100 : null;
        
        $pencapaian = 'N/A';
        if ($nilai !== null) {
            $pencapaian = 'tidak-tercapai';
            if ($spm->arah_target == 'lebih_besar' && $nilai >= $spm->target_spm) $pencapaian = 'tercapai';
            elseif ($spm->arah_target == 'lebih_kecil' && $nilai <= $spm->target_spm) $pencapaian = 'tercapai';
            elseif ($spm->arah_target == 'range' && $nilai >= $spm->target_min && $nilai <= $spm->target_max) $pencapaian = 'tercapai';
        }

        if ($request->hasFile('file_laporan')) {
            if ($laporan->file_laporan) {
                Storage::disk('public')->delete($laporan->file_laporan);
            }
            $file = $request->file('file_laporan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $laporan->file_laporan = $file->storeAs('laporan_spm', $filename, 'public');
        }

        $laporan->numerator = $request->numerator;
        $laporan->denominator = $request->denominator;
        $laporan->nilai = $nilai !== null ? round($nilai, 2) : null;
        $laporan->pencapaian = $pencapaian;
        $laporan->save();

        return redirect()->back()->with('success', 'Data SPM berhasil diupdate');
    }
}
