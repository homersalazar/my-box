<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Line;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function index()
    {
        $folders = Header::where('user_id', auth()->id())->get();
        return view('files.index', compact('folders'));
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

            return redirect()->back()->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors([
                'error' => 'Failed to create folder: ' . $e->getMessage()
            ])->withInput();
        }
    }

    // LINES
    public function create_file(Request $request)
    {
        $request->validate([
            'files' => 'required|array|max:10', // Limit to 10 files
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx'
        ]);

        try {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $ext          = $file->getClientOriginalExtension();
                    $baseName     = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                    $copies = Line::where('user_id', auth()->id())
                        ->where('file_name', 'LIKE', $baseName . '%.' . $ext)
                        ->count();

                    $suffix       = $copies ? '_' . ($copies + 1) : '';

                    $storedName   = auth()->id() . '_' . Str::slug($baseName) . $suffix . '.' . $ext;
                    $displayName  = $baseName . $suffix . '.' . $ext;

                    $file->storeAs('uploads', $storedName, 'public');

                    Line::create([
                        'user_id'   => auth()->id(),
                        'file_name' => $displayName,
                        'file_path' => $storedName,
                        'status'    => 0,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'File(s) uploaded successfully!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No files received',
                ], 400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
