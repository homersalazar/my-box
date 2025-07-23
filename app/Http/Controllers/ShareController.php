<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function index()
    {
        return view('share.index');
    }

    public function autocomplete(Request $request)
    {
        // if ($request->get('query')) {
        //     $query = $request->get('query');
        //     $data = Product::where('prod_name', 'LIKE', "%{$query}%")
        //         ->orWhere('prod_sku', 'LIKE', "%{$query}%")
        //         ->get();

        //     if (count($data) > 0) {
        //         $output = '<table class="w-full text-sm text-left">
        //                         <thead>
        //                             <tr>
        //                                 <th scope="col" class="px-6 py-3">
        //                                     Product Name
        //                                 </th>
        //                                 <th scope="col" class="px-6 py-3">
        //                                     SKU
        //                                 </th>
        //                                 <th scope="col" class="px-6 py-3 max-sm:hidden">
        //                                     Part Number
        //                                 </th>
        //                                 <th scope="col" class="px-6 py-3">
        //                                     Manufacturer
        //                                 </th>
        //                             </tr>
        //                         </thead>
        //                         <tbody>';
        //         foreach ($data as $row) {
        //             $output .= '<tr class="border-b px-6">
        //                             <td class="p-2 px-6 font-medium text-gray-900 whitespace-nowrap underline text-blue-800 cursor-pointer">';
        //             $output .= '<a href="' . route('transaction.show', $row->prod_sku) . '">
        //                                 ' . ucwords($row->prod_name) . '
        //                             </a>';
        //             $output .= '</td>
        //                         <td class="px-6">
        //                             SKU0' . $row->prod_sku . '
        //                         </td>
        //                         <td class="px-6 max-sm:hidden">
        //                             ' . strtoupper($row->prod_partno) . '
        //                         </td>
        //                         <td class="px-6">
        //                             ' . ucwords($row->manufacturer?->manufacturer_name) . '
        //                         </td>
        //                     </tr>';
        //         }
        //         $output .= '</tbody></table>';
        //     } else {
        //         $output = '<div class="text-center border-t border-b text-base p-2">No Item found</div>';
        //     }
        //     return $output;
        // }
    }
}
