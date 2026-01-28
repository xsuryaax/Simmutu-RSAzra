<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
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
}
