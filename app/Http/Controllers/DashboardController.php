<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $folders = Header::where('user_id', auth()->id())->get();
        return view('dashboard.index', compact('folders'));
    }
}
