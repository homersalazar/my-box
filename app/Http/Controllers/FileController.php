<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function index()
    {
        return view('files.index');
    }

    // HEADERS
    public function create_folder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {

            Header::create([
                'folder_name' => $request->folder_name,
                'user_id' => auth()->id()
            ]);

            DB::commit();

            return redirect()->route('files.index')->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'error' => 'Failed to create folder: ' . $e->getMessage()
            ])->withInput();
        }
    }
}
