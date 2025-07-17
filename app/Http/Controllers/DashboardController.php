<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Line;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $folders = Header::where('user_id', auth()->id())->get();
        $files = Line::where('user_id', auth()->id())->get();

        $docs = $files->filter(function ($file) {
            $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
            return in_array($extension, ['doc', 'docx', 'pdf', 'xls', 'xlsx']);
        })->count();

        $images = $files->filter(function ($file) {
            $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
            return in_array($extension, ['jpeg', 'jpg', 'png']);
        })->count();
        return view('dashboard.index', compact('folders', 'files', 'docs', 'images'));
    }
}
