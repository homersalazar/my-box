<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Line;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $allFiles = Line::where('user_id', auth()->id())
            ->where('status', '=', '0')
            ->get();
        $folders = Header::where('user_id', auth()->id())->paginate(10);
        $files = Line::where('user_id', auth()->id())
            ->where('status', '=', '0')
            ->whereNull('header_id')
            ->paginate(10);

        $docs = $allFiles->filter(function ($allFiles) {
            $extension = strtolower(pathinfo($allFiles->file_path, PATHINFO_EXTENSION));
            return in_array($extension, ['doc', 'docx', 'pdf', 'xls', 'xlsx']);
        })->count();

        $images = $allFiles->filter(function ($allFiles) {
            $extension = strtolower(pathinfo($allFiles->file_path, PATHINFO_EXTENSION));
            return in_array($extension, ['jpeg', 'jpg', 'png']);
        })->count();
        return view('dashboard.index', compact('folders', 'files', 'docs', 'images'));
    }
}
