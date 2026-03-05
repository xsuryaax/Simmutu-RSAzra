<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;

class ExportPdfController extends Controller
{
    public function exportChart(Request $request)
    {
        $request->validate([
            'chart_image' => 'required',
            'judul' => 'required'
        ]);

        $pdf = PDF::loadView('menu.ExportPdf.chart', [
            'judul' => $request->judul,
            'chart' => $request->chart_image
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            str_replace(' ', '_', strtolower($request->judul)) . '.pdf'
        );
    }

    public function exportPdsa(Request $request)
    {
        $filterUnit = $request->unit_id;
        $filterTahun = $request->tahun;

        $data = DB::table('tbl_pdsa_assignments as a')
            ->leftJoin('tbl_indikator as i', 'a.indikator_id', '=', 'i.id')
            ->leftJoin('tbl_unit as u', 'a.unit_id', '=', 'u.id')
            ->leftJoin('tbl_pdsa as p', 'a.id', '=', 'p.assignment_id')
            ->when($filterUnit, function ($query) use ($filterUnit) {
                $query->where('a.unit_id', $filterUnit);
            })
            ->when($filterTahun, function ($query) use ($filterTahun) {
                $query->where('a.tahun', $filterTahun);
            })
            ->select(
                'i.nama_indikator',
                'u.nama_unit',
                'a.tahun',
                'a.quarter',
                'a.status_pdsa',
                'p.plan',
                'p.do',
                'p.study',
                'p.action'
            )
            ->orderBy('a.tahun', 'desc')
            ->get();

        $pdf = Pdf::loadView('menu.ExportPdf.pdsa', [
            'data' => $data,
            'tahun' => $filterTahun
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_PDSA.pdf');
    }
}
