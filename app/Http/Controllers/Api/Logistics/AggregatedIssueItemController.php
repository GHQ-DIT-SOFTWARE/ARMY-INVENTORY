<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Logistics;

use App\Http\Controllers\Controller;
use App\Models\AggregatedIssueItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AggregatedIssueItemController extends Controller
{

    public function index()
    {
        $items = AggregatedIssueItem::whereJsonContains('items', [['STATUS' => 0]])
            ->get()
            ->map(function ($item) {
                $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

                // Fetch item names using ITEM_IDs from the items array
                $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
                $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');
                // Transform each item data into a structured format for display
                $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
                    $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
                    $status = $data['STATUS'] == 0 ? '<span class="badge badge-warning">Pending Issurance</span>' : 'Pending';
                    // Build the details for each item
                    $itemDetails = [
                        'Category' => $data['CATEGORY_ID'],
                        'Sub Category' => $data['SUB_CATEGORY'],
                        'Item Name' => $itemName,
                        'Size' => $data['SIZES'],
                        'Quantity' => $data['QTY'],
                        'Unit ID' => $data['UNIT_ID'],
                        'Description' => $data['DESCRIPTION'],
                        'Status' => $status,
                        'Invoice No' => $data['INVOICE_NO'],
                    ];

                    return $itemDetails;
                });

                return [
                    'uuid' => $item->uuid,
                    'invoice_no' => $item->invoice_no,
                    'items' => $formattedItems,
                ];
            });

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a class="btn btn-primary btn-sm" href="' . route('item-issued-pdf', $item['uuid']) . '" target="_blank"><i class="feather icon-eye"></i> Print</a>,
                <a class="btn btn-primary btn-sm" href="' . route('edit-item-issued-out', $item['uuid']) . '"><i class="feather icon-eye"></i> Edit</a>';
            })
            ->editColumn('items', function ($item) {
                $html = '<table class="table table-sm table-bordered">';
                // Add headers
                $html .= '<thead><tr>';
                if (!empty($item['items']->first())) {
                    foreach ($item['items']->first() as $key => $value) {
                        $html .= '<th>' . $key . '</th>';
                    }
                }
                $html .= '</tr></thead><tbody>';
                // Add records
                foreach ($item['items'] as $i) {
                    $html .= '<tr>';
                    foreach ($i as $key => $value) {
                        $html .= '<td>' . $value . '</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</tbody></table>';
                return $html;
            })
            ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
            ->make(true);
    }
    public function item_issued(Request $request)
    {
        // Retrieve invoice_no from request
        $invoice_no = $request->input('invoice_no');

        // Query to fetch records based on invoice_no
        $itemsQuery = AggregatedIssueItem::where('invoice_no', $invoice_no)
            ->whereJsonContains('items', [['STATUS' => 1]]) // Optional condition for JSON column
            ->get();

        // Transform data as needed (assuming your existing transformation logic)
        $items = $itemsQuery->map(function ($item) {
            $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;
            $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
            $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');
            $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
                $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item';
                $status = $data['STATUS'] == 1 ? '<span class="badge badge-success">Issuance Issued</span>' : 'Pending';
                $itemDetails = [
                    'Category' => $data['CATEGORY_ID'],
                    'Sub Category' => $data['SUB_CATEGORY'],
                    'Item Name' => $itemName,
                    'Size' => $data['SIZES'],
                    'Quantity' => $data['QTY'],
                    'Unit ID' => $data['UNIT_ID'],
                    'Description' => $data['DESCRIPTION'],
                    'Status' => $status,
                    'Invoice No' => $data['INVOICE_NO'],
                    'Confirm Qty' => $data['CONFIRM_QTY'],
                    'Remarks' => $data['REMARKS'],
                ];
                return $itemDetails;
            });

            return [
                'uuid' => $item->uuid,
                'invoice_no' => $item->invoice_no,
                'items' => $formattedItems,
            ];
        });

        // Return data as DataTables response
        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a class="btn btn-primary btn-sm" href="' . route('item-issued-pdf', $item['uuid']) . '" target="_blank"><i class="feather icon-eye"></i> Print</a>';
            })
            ->editColumn('items', function ($item) {
                $html = '<table class="table table-sm table-bordered">';
                $html .= '<thead><tr>';
                if (!empty($item['items']->first())) {
                    foreach ($item['items']->first() as $key => $value) {
                        $html .= '<th>' . $key . '</th>';
                    }
                }
                $html .= '</tr></thead><tbody>';
                foreach ($item['items'] as $i) {
                    $html .= '<tr>';
                    foreach ($i as $key => $value) {
                        $html .= '<td>' . $value . '</td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</tbody></table>';
                return $html;
            })
            ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
            ->make(true); // Return DataTables JSON response
    }
    // public function item_issued()
    // {
    //     $items = AggregatedIssueItem::whereJsonContains('items', [['STATUS' => 1]])
    //         ->get()
    //         ->map(function ($item) {
    //             $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;
    //             // Fetch item names using ITEM_IDs from the items array
    //             $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //             $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');
    //             // Transform each item data into a structured format for display
    //             $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //                 $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //                 $status = $data['STATUS'] == 1 ? '<span class="badge badge-success">Issuance Issued</span>' : 'Pending';
    //                 // Build the details for each item
    //                 $itemDetails = [
    //                     'Category' => $data['CATEGORY_ID'],
    //                     'Sub Category' => $data['SUB_CATEGORY'],
    //                     'Item Name' => $itemName,
    //                     'Size' => $data['SIZES'],
    //                     'Quantity' => $data['QTY'],
    //                     'Unit ID' => $data['UNIT_ID'],
    //                     'Description' => $data['DESCRIPTION'],
    //                     'Status' => $status,
    //                     'Invoice No' => $data['INVOICE_NO'],
    //                     'Confirm Qty' => $data['CONFIRM_QTY'],
    //                     'Remarks' => $data['REMARKS'],
    //                 ];

    //                 return $itemDetails;
    //             });

    //             return [
    //                 'uuid' => $item->uuid,
    //                 'invoice_no' => $item->invoice_no,
    //                 'items' => $formattedItems,
    //             ];
    //         });

    //     return DataTables::of($items)
    //         ->addColumn('action', function ($item) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('item-issued-pdf', $item['uuid']) . '" target="_blank"><i class="feather icon-eye"></i> Print</a>';
    //         })
    //         ->editColumn('items', function ($item) {
    //             $html = '<table class="table table-sm table-bordered">';
    //             // Add headers
    //             $html .= '<thead><tr>';
    //             if (!empty($item['items']->first())) {
    //                 foreach ($item['items']->first() as $key => $value) {
    //                     $html .= '<th>' . $key . '</th>';
    //                 }
    //             }
    //             $html .= '</tr></thead><tbody>';
    //             // Add records
    //             foreach ($item['items'] as $i) {
    //                 $html .= '<tr>';
    //                 foreach ($i as $key => $value) {
    //                     $html .= '<td>' . $value . '</td>';
    //                 }
    //                 $html .= '</tr>';
    //             }
    //             $html .= '</tbody></table>';
    //             return $html;
    //         })
    //         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
    //         ->make(true);
    // }

    // public function index()
    // {
    //     $items = AggregatedIssueItem::all()->map(function ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;
    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Transform each item data into a string format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //             $status = $data['STATUS'] == 0 ? '<span class="badge badge-warning">Pending Issuance</span>' : 'Issued';
    //             $itemDetails = implode(', ', [
    //                 'Category: ' . $data['CATEGORY_ID'],
    //                 'Sub Category: ' . $data['SUB_CATEGORY'],
    //                 'Item Name: ' . $itemName, // Display item name instead of ITEM_ID
    //                 'Size: ' . $data['SIZES'],
    //                 'Quantity: ' . $data['QTY'],
    //                 'Unit ID: ' . $data['UNIT_ID'],
    //                 'Description: ' . $data['DESCRIPTION'],
    //                 'Status: ' . $status, // Add status to the details with HTML span
    //             ]);
    //             return ($index + 1) . '. ' . $itemDetails;
    //         })->implode('<br>');

    //         return [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //         ];
    //     });

    //     return DataTables::of($items)
    //         ->addColumn('action', function ($item) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('edit-item-issued-out', $item['uuid']) . '"><i class="feather icon-edit"></i> Edit</a>';
    //         })
    //         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
    //         ->make(true);
    // }

    // public function item_issued()
    // {
    //     $items = AggregatedIssueItem::whereJsonContains('items', [['STATUS' => 1]])
    //         ->get()
    //         ->map(function ($item) {
    //             $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //             // Fetch item names using ITEM_IDs from the items array
    //             $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //             $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //             // Transform each item data into a structured format for display
    //             $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //                 $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //                 $status = $data['STATUS'] == 1 ? '<span class="badge badge-success">Issuance Issued</span>' : 'Pending';

    //                 // Build the details for each item
    //                 $itemDetails = [
    //                     'Category' => $data['CATEGORY_ID'],
    //                     'Sub Category' => $data['SUB_CATEGORY'],
    //                     'Item Name' => $itemName,
    //                     'Size' => $data['SIZES'],
    //                     'Quantity' => $data['QTY'],
    //                     'Unit' => $data['UNIT_ID'],
    //                     'Description' => $data['DESCRIPTION'],
    //                     'Status' => $status,
    //                 ];

    //                 return $itemDetails;
    //             });

    //             return [
    //                 'uuid' => $item->uuid,
    //                 'invoice_no' => $item->invoice_no,
    //                 'items' => $formattedItems,
    //             ];
    //         });

    //     return DataTables::of($items)
    //         ->addColumn('action', function ($item) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('edit-item-issued-out', $item['uuid']) . '"><i class="feather icon-eye"></i> Edit</a>';
    //         })
    //         ->editColumn('items', function ($item) {
    //             $html = '<table class="table table-sm table-bordered">';
    //             // Add headers
    //             $html .= '<thead><tr>';
    //             if (!empty($item['items']->first())) {
    //                 foreach ($item['items']->first() as $key => $value) {
    //                     $html .= '<th>' . $key . '</th>';
    //                 }
    //             }
    //             $html .= '</tr></thead><tbody>';
    //             // Add records
    //             foreach ($item['items'] as $i) {
    //                 $html .= '<tr>';
    //                 foreach ($i as $key => $value) {
    //                     $html .= '<td>' . $value . '</td>';
    //                 }
    //                 $html .= '</tr>';
    //             }
    //             $html .= '</tbody></table>';
    //             return $html;
    //         })
    //         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
    //         ->make(true);
    // }

    // public function item_issued()
    // {
    //     $items = AggregatedIssueItem::whereJsonContains('items', [['STATUS' => 1]])
    //         ->get()
    //         ->map(function ($item) {
    //             $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //             // Fetch item names using ITEM_IDs from the items array
    //             $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //             $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //             // Transform each item data into a structured format for display
    //             $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //                 $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //                 $status = $data['STATUS'] == 1 ? '<span class="badge badge-success">Issuance Issued</span>' : 'Pending';

    //                 // Build the details for each item
    //                 $itemDetails = [
    //                     'Category' => $data['CATEGORY_ID'],
    //                     'Sub Category' => $data['SUB_CATEGORY'],
    //                     'Item Name' => $itemName,
    //                     'Size' => $data['SIZES'],
    //                     'Quantity' => $data['QTY'],
    //                     'Unit ID' => $data['UNIT_ID'],
    //                     'Description' => $data['DESCRIPTION'],
    //                     'Status' => $status,
    //                 ];

    //                 return $itemDetails;
    //             });

    //             return [
    //                 'uuid' => $item->uuid,
    //                 'invoice_no' => $item->invoice_no,
    //                 'items' => $formattedItems,
    //             ];
    //         });

    //     return DataTables::of($items)
    //         ->addColumn('action', function ($item) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('edit-item-issued-out', $item['uuid']) . '"><i class="feather icon-eye"></i> Edit</a>';
    //         })
    //         ->editColumn('items', function ($item) {
    //             $html = '<table class="table table-sm table-bordered">';
    //             foreach ($item['items'] as $i) {
    //                 $html .= '<tr>';
    //                 foreach ($i as $key => $value) {
    //                     $html .= '<td>' . $key . '</td><td>' . $value . '</td>';
    //                 }
    //                 $html .= '</tr>';
    //             }
    //             $html .= '</table>';
    //             return $html;
    //         })
    //         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
    //         ->make(true);
    // }

// '<a class="btn btn-danger btn-sm ml-1" href="' . route('delete-item-issued-out', $item['uuid']) . '" id="delete"><i class="feather icon-trash-2"></i> Delete</a>'
    // public function index()
    // {
    //     $items = AggregatedIssueItem::all()->map(function ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Transform each item data into a string format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //             $itemDetails = implode(', ', [
    //                 'Category: ' . $data['CATEGORY_ID'],
    //                 'Sub Category: ' . $data['SUB_CATEGORY'],
    //                 'Item Name: ' . $itemName, // Display item name instead of ITEM_ID
    //                 'Size: ' . $data['SIZES'],
    //                 'Quantity: ' . $data['QTY'],
    //                 'Unit ID: ' . $data['UNIT_ID'],
    //                 'Description: ' . $data['DESCRIPTION'],
    //             ]);
    //             return ($index + 1) . '. ' . $itemDetails;
    //         })->implode('<br>');

    //         return [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //         ];
    //     });

    //     return DataTables::of($items)
    //         ->addColumn('action', function ($item) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('edit-item-issued-out', $item['uuid']) . '"><i class="feather icon-edit"></i> Edit</a>' .
    //             '<a class="btn btn-danger btn-sm ml-1" href="' . route('delete-item-issued-out', $item['uuid']) . '" id="delete"><i class="feather icon-trash-2"></i> Delete</a>';
    //         })
    //         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
    //         ->make(true);
    // }
//     public function index()
// {
//     $items = AggregatedIssueItem::all()->map(function ($item) {
//         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;
//         // Fetch item names using ITEM_IDs from the items array
//         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
//         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');
//         // Transform each item data into a string format for display
//         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
//             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
//             $itemDetails = implode(', ', [
//                 'Category: ' . $data['CATEGORY_ID'],
//                 'Sub Category: ' . $data['SUB_CATEGORY'],
//                 'Item Name: ' . $itemName, // Display item name instead of ITEM_ID
//                 'Size: ' . $data['SIZES'],
//                 'Quantity: ' . $data['QTY'],
//                 'Unit ID: ' . $data['UNIT_ID'],
//                 'Description: ' . $data['DESCRIPTION'],
//             ]);
//             return ($index + 1) . '. ' . $itemDetails;
//         })->implode('<br>');

//         return [
//             'uuid' => $item->uuid,
//             'invoice_no' => $item->invoice_no,
//             'items' => $formattedItems,
//         ];
//     });

//     return DataTables::of($items)
//         ->addColumn('action', function ($item) {
//             return '<a class="btn btn-danger btn-sm" href="' . route('delete-item-issued-out', $item['uuid']) . '" id="delete"><i class="feather icon-trash-2"></i></a>';
//         })
//         ->rawColumns(['items', 'action']) // Mark 'items' and 'action' columns as raw HTML
//         ->make(true);
// }

}
