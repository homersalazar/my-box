<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Shareds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{
    public function index()
    {
        return view('share.index');
    }

    public function share_file(Request $request)
    {
        $request->validate([
            'shared_file_id' => 'required|integer|exists:lines,id',
            'selected_user_ids' => 'required'
        ]);

        $userIds = array_filter(explode(",", $request->selected_user_ids));

        if (empty($userIds)) {
            return back()->with('error', 'No users selected for sharing.');
        }

        DB::beginTransaction();

        try {
            // Check if file exists and user has permission to share it
            $file = Line::findOrFail($request->shared_file_id);

            if (empty($file)) {
                return back()->with('error', 'No file found.');
            }
            // Prevent duplicate shares
            $existingShares = Shareds::whereIn('user_id', $userIds)
                ->where('shareable_id', $request->shared_file_id)
                ->where('shareable_type', 'Lines')
                ->pluck('shareable_id')
                ->toArray();

            $newUserIds = array_diff($userIds, $existingShares);

            if (empty($newUserIds)) {
                return back()->with('error', 'File is already shared with all selected users.');
            }

            foreach ($newUserIds as $userId) {
                // Validate that user exists
                if (User::find($userId)) {
                    Shareds::create([
                        'shareable_id'   => $request->shared_file_id,
                        'shareable_type' => 'Lines',
                        'user_id' => $userId,
                    ]);
                }
            }

            DB::commit();

            return back()->with('success', 'File shared successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error',  'Upload failed: ' . $e->getMessage());
        }
    }

    // public function autocomplete(Request $request)
    // {
    //     // if ($request->get('query')) {
    //     //     $query = $request->get('query');
    //     //     $data = Product::where('prod_name', 'LIKE', "%{$query}%")
    //     //         ->orWhere('prod_sku', 'LIKE', "%{$query}%")
    //     //         ->get();

    //     //     if (count($data) > 0) {
    //     //         $output = '<table class="w-full text-sm text-left">
    //     //                         <thead>
    //     //                             <tr>
    //     //                                 <th scope="col" class="px-6 py-3">
    //     //                                     Product Name
    //     //                                 </th>
    //     //                                 <th scope="col" class="px-6 py-3">
    //     //                                     SKU
    //     //                                 </th>
    //     //                                 <th scope="col" class="px-6 py-3 max-sm:hidden">
    //     //                                     Part Number
    //     //                                 </th>
    //     //                                 <th scope="col" class="px-6 py-3">
    //     //                                     Manufacturer
    //     //                                 </th>
    //     //                             </tr>
    //     //                         </thead>
    //     //                         <tbody>';
    //     //         foreach ($data as $row) {
    //     //             $output .= '<tr class="border-b px-6">
    //     //                             <td class="p-2 px-6 font-medium text-gray-900 whitespace-nowrap underline text-blue-800 cursor-pointer">';
    //     //             $output .= '<a href="' . route('transaction.show', $row->prod_sku) . '">
    //     //                                 ' . ucwords($row->prod_name) . '
    //     //                             </a>';
    //     //             $output .= '</td>
    //     //                         <td class="px-6">
    //     //                             SKU0' . $row->prod_sku . '
    //     //                         </td>
    //     //                         <td class="px-6 max-sm:hidden">
    //     //                             ' . strtoupper($row->prod_partno) . '
    //     //                         </td>
    //     //                         <td class="px-6">
    //     //                             ' . ucwords($row->manufacturer?->manufacturer_name) . '
    //     //                         </td>
    //     //                     </tr>';
    //     //         }
    //     //         $output .= '</tbody></table>';
    //     //     } else {
    //     //         $output = '<div class="text-center border-t border-b text-base p-2">No Item found</div>';
    //     //     }
    //     //     return $output;
    //     // }
    // }
}
