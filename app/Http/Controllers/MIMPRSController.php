<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MIMPRSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu.master-indikator-mutu-prioritas-rs.index');
    }

    public function create()
    {
        return view('menu.master-indikator-mutu-prioritas-rs.create');
    }

    public function edit()
    {
        return view('menu.master-indikator-mutu-prioritas-rs.edit');
    }
}
