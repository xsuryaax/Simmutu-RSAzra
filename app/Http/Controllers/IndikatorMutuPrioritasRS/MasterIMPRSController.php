<?php

namespace App\Http\Controllers\IndikatorMutuPrioritasRS;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MasterIMPRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu.IndikatorMutuPrioritasRS.master-imprs.index');
    }

    public function create()
    {
        return view('menu.IndikatorMutuPrioritasRS.master-imprs.create');
    }

    public function edit()
    {
        return view('menu.IndikatorMutuPrioritasRS.master-imprs.edit');
    }
}
