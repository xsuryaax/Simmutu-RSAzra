<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Validator;

class MIMNController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu.master-indikator-mutu-nasional.index');
    }

    public function create()
    {
        return view('menu.master-indikator-mutu-nasional.create');
    }

    public function edit()
    {
        return view('menu.master-indikator-mutu-nasional.edit');
    }
}
