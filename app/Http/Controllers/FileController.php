<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Line;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipStream\ZipStream;
use Exception;

class FileController extends Controller
{
    public function index()
    {
        $folders = Header::where('user_id', auth()->id())->paginate(10);
        $files = Line::where('user_id', auth()->id())
            ->where('line_status', '=', '0')
            ->whereNull('header_id')
            ->paginate(10);
        return view('files.index', compact('folders', 'files'));
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

    public function show_folder($id)
    {
        $folders = Header::where('id', $id)->first();
        $files = Line::where('header_id', $id)->where('status', '=', '0')->paginate(10);
        return view('files.show_folder', compact('folders', 'files'));
    }

    public function download_folder($id)
    {
        try {
            // Fetch the folder and related files
            $folder = Header::findOrFail($id);
            $files = Line::where('header_id', $id)->where('status', '=', '0')->get();

            // Validate folder name
            $folderName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $folder->folder_name);
            if (empty($folderName)) {
                $folderName = 'folder_' . $id;
            }

            // Create ZIP stream
            $zipFileName = $folderName . '_' . time() . '.zip';
            $zip = new ZipStream(
                outputName: $zipFileName,
                sendHttpHeaders: true
            );

            // Add each file to the ZIP
            $filesAdded = false;
            foreach ($files as $file) {
                $sourcePath = storage_path('/public/uploads/' . $file->file_path);
                if (file_exists($sourcePath)) {
                    // Add file to ZIP with folder structure
                    $zipPath = $folderName . '/' . basename($file->file_path);
                    $zip->addFileFromPath($zipPath, $sourcePath);
                    $filesAdded = true;
                } else {
                    Log::warning('File not found: ' . $sourcePath);
                }
            }

            // Check if any files were added
            if (!$filesAdded) {
                throw new Exception('No valid files found to include in the ZIP');
            }

            // Finish the ZIP stream
            $zip->finish();
            exit; // Ensure no further output
        } catch (Exception $e) {
            Log::error('Error creating ZIP file: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to create ZIP file: ' . $e->getMessage());
        }
    }

    public function rename_folder(Request $request, $id)
    {
        $request->validate([
            'folder_name' => 'required|string|max:20',
        ]);

        DB::beginTransaction();

        try {

            $folder = Header::findOrFail($id);
            $folder->folder_name = ucfirst($request->input('folder_name'));
            $folder->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Folder updated successfully!',
            ]);
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

        DB::beginTransaction();

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
                        'line_status'    => 0, // 0 - created, 1 - soft delete, 2 - hard delete
                    ]);
                }

                DB::commit();

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
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function autocomplete(Request $request)
    {
        $query = trim($request->get('query'));
        $searchTerm = '%' . $query . '%';
        if (!empty($query)) {
            $data = User::where('id', '!=', auth()->id())
                ->select('id', 'firstname', 'lastname', 'email')
                ->where(function ($q) use ($searchTerm) {
                    $q->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", [$searchTerm])
                        ->orWhere('firstname', 'LIKE', $searchTerm)
                        ->orWhere('lastname', 'LIKE', $searchTerm)
                        ->orWhere('email', 'LIKE', $searchTerm);
                })
                ->limit(10)
                ->get();

            if ($data->count() > 0) {
                $output = '<ul class="max-w-full divide-y divide-gray-200 bg-gray-50 dark:divide-gray-700 rounded-sm">';
                foreach ($data as $row) {
                    $full_name = ucfirst($row->firstname) . ' ' . ucfirst($row->lastname);

                    // Properly escape the data for JavaScript
                    $escaped_name = addslashes(htmlspecialchars($full_name));

                    $output .= '<li class="p-1.5 cursor-pointer hover:bg-gray-200"
                    onclick="selectUser(' . $row->id . ', \'' . $escaped_name . '\')">
                    ' . htmlspecialchars($full_name) . '<br><span class="text-sm text-gray-500">' . htmlspecialchars($row->email) . '</span>
                </li>';
                }
                $output .= '</ul>';
            } else {
                $output = '<div class="text-center border-t border-b text-base p-2 text-gray-500">No data found</div>';
            }

            return $output;
        }

        return '';
    }
}

    // public function download_folder($id)
    // {
    //     $folder = Header::findOrFail($id);
    //     $files = Line::where('header_id', $id)->get();

    //     if ($files->isEmpty()) {
    //         throw new Exception('No files found for this folder');
    //     }

    //     // If only one file, download it directly
    //     if ($files->count() === 1) {
    //         $file = $files->first();
    //         $filePath = storage_path('app/public/uploads/' . $file->file_path);
    //         if (file_exists($filePath)) {
    //             return response()->download($filePath, $file->name);
    //         }
    //         throw new Exception('File not found: ' . $filePath);
    //     }

    //     // Create a temporary directory
    //     $tempDir = storage_path('app/public/temp/' . $folder->folder_name);
    //     if (!file_exists($tempDir)) {
    //         mkdir($tempDir, 0755, true);
    //     }

    //     // Copy files to the temporary directory
    //     foreach ($files as $file) {
    //         $sourcePath = storage_path('app/public/uploads/' . $file->file_path);
    //         $destPath = $tempDir . '/' . basename($file->file_path);
    //         if (file_exists($sourcePath)) {
    //             copy($sourcePath, $destPath);
    //         }
    //     }

    //     // Note: Downloading a folder without zipping isn't directly supported by browsers
    //     // Return a message or handle differently (e.g., provide a list of file links)
    //     return response()->json([
    //         'message' => 'Multiple files found. ZipArchive is not available. Files copied to: ' . $tempDir,
    //         'files' => $files->pluck('file_path')->toArray(),
    //     ]);
    // }
