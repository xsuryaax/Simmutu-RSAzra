<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class LaporanAnalisIMPRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu.IndikatorMutuPrioritasRS.laporan-analis-imprs.index');
    }

    public function create()
    {
        return view('menu.IndikatorMutuPrioritasRS.laporan-analis-imprs.create');
    }

    public function edit()
    {
        return view('menu.IndikatorMutuPrioritasRS.laporan-analis-imprs.edit');
    }
}
