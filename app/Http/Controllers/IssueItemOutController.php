<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\AggregatedIssueItem;
use App\Models\Category;
use App\Models\IssueItemOut;
use App\Models\Item;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request; // Import DB facade for transactions
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class IssueItemOutController extends Controller
{
    public function index()
    {
        return view('Issueitemout.index');
    }

    public function aggreagtated_issue_item()
    {
        return view('Issueitemout.aggregated_issue_items');
    }
    public function issued_items()
    {
        return view('Issueitemout.issued_items_aggregated');
    }
    public function issueout()
    {
        $category = Category::all();
        $units = Unit::all();
        $products = Item::orderBy('item_name', 'ASC')->get();
        return view('Issueitemout.issueitemout', compact('products', 'category', 'units'));
    }
    public function getLastInvoiceNumber()
    {
        $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
        $lastInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_no : null;
        return response()->json(['last_invoice_number' => $lastInvoiceNumber]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|array',
            'sub_category' => 'required|array',
            'item_id' => 'required|array',
            'sizes' => 'nullable|array',
            'qty' => 'required|array',
            'unit_id' => 'required|array',
            'description' => 'nullable|string',
            'invoice_no' => 'nullable|string',
        ]);

        $unitIds = array_unique($validatedData['unit_id']);
        if (count($unitIds) > 1) {
            return back()->withErrors(['unit_id' => 'A unit at a time. All items must belong to the same unit.']);
        }
        try {
            DB::beginTransaction();

            $lastInvoice = IssueItemOut::orderBy('id', 'desc')->first();
            $lastInvoiceNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_no, FILTER_SANITIZE_NUMBER_INT) : 0;
            $newInvoiceNumber = $lastInvoiceNumber + 1;
            $formattedInvoiceNumber = 'INVOICE-' . $newInvoiceNumber . '-' . now()->year;

            $issueItems = [];
            $currentDate = now();
            $aggregatedItems = []; // Array to hold aggregated items data
            $createdBy = auth()->user()->id;
            foreach ($validatedData['item_id'] as $index => $itemName) {
                $item = Item::where('item_name', $itemName)->first();
                if (!$item) {
                    return back()->withErrors(['item_id' => "Item $itemName not found."]);
                }

                $requestedQty = $validatedData['qty'][$index];
                if ($requestedQty > $item->qty) {
                    return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
                }

                // Subtract the quantity from the item
                $item->qty -= $requestedQty;
                $item->save();

                // Add the issue item to the array for IssueItemOut

                $issueItems[] = [
                    'uuid' => (string) Str::uuid(), // Generate a UUID for each record
                    'category_id' => $validatedData['category_id'][$index],
                    'sub_category' => $validatedData['sub_category'][$index],
                    'item_id' => $item->id, // Storing item ID
                    'sizes' => $validatedData['sizes'][$index],
                    'qty' => $requestedQty,
                    'unit_id' => $validatedData['unit_id'][$index],
                    'description' => $validatedData['description'] ?? '',
                    'invoice_no' => $formattedInvoiceNumber,
                    'created_by' => $createdBy,
                    'date' => $currentDate, // Automatically set the current date and time
                    'created_at' => now(), // Assuming you have timestamps in your table
                    'updated_at' => now(), // Assuming you have timestamps in your table
                    'status' => 0, // Setting the status field to 0
                ];

                // Add item to aggregated items array for AggregatedIssueItem
                $aggregatedItems[] = [
                    'category_id' => $validatedData['category_id'][$index],
                    'sub_category' => $validatedData['sub_category'][$index],
                    'item_id' => $item->id,
                    'sizes' => $validatedData['sizes'][$index],
                    'qty' => $requestedQty,
                    'unit_id' => $validatedData['unit_id'][$index],
                    'description' => $validatedData['description'] ?? '',
                    'invoice_no' => $formattedInvoiceNumber, // Add invoice_no here
                    'status' => 0,
                    'created_by' => $createdBy,
                    'date' => $currentDate,
                ];
            }

            // Insert into IssueItemOut
            IssueItemOut::insert($issueItems);

            AggregatedIssueItem::create([
                'uuid' => (string) Str::uuid(),
                'invoice_no' => $formattedInvoiceNumber,
                'items' => json_encode($aggregatedItems),
                'created_by' => $createdBy,
                'created_at' => $currentDate,
            ]);
            // AggregatedIssueItem::create([
            //     'uuid' => (string) Str::uuid(),
            //     'invoice_no' => $formattedInvoiceNumber,
            //     'items' => json_encode($aggregatedItems),
            // ]);
            DB::commit();
            $notification = [
                'message' => 'Items issued successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($notification);

        } catch (Exception $e) {
            DB::rollBack();
            // Log the exception message
            Log::error('Error issuing items: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while issuing items. Please try again.']);
        }
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'category_id' => 'required|array',
    //         'sub_category' => 'required|array',
    //         'item_id' => 'required|array',
    //         'sizes' => 'required|array',
    //         'qty' => 'required|array',
    //         'unit_id' => 'required|array',
    //         'description' => 'nullable|string',
    //         'invoice_no' => 'nullable|string',
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Fetch the last invoice number and increment it
    //         $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
    //         $lastInvoiceNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_no, FILTER_SANITIZE_NUMBER_INT) : 0;
    //         $newInvoiceNumber = $lastInvoiceNumber + 1;
    //         $formattedInvoiceNumber = 'INVOICE-NO-' . $newInvoiceNumber . '-' . now()->year;

    //         $issueItems = [];
    //         $currentDate = now();
    //         $aggregatedItems = []; // Array to hold aggregated items data
    //         foreach ($validatedData['item_id'] as $index => $itemName) {
    //             $item = Item::where('item_name', $itemName)->first();
    //             if (!$item) {
    //                 return back()->withErrors(['item_id' => "Item $itemName not found."]);
    //             }
    //             $requestedQty = $validatedData['qty'][$index];
    //             if ($requestedQty > $item->qty) {
    //                 return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
    //             }
    //             // Subtract the quantity from the item
    //             $item->qty -= $requestedQty;
    //             $item->save();
    //             // Add the issue item to the array
    //             $issueItems[] = [
    //                 'uuid' => (string) Str::uuid(), // Generate a UUID for each record
    //                 'category_id' => $validatedData['category_id'][$index],
    //                 'sub_category' => $validatedData['sub_category'][$index],
    //                 'item_id' => $item->id, // Storing item ID instead of name
    //                 'sizes' => $validatedData['sizes'][$index],
    //                 'qty' => $requestedQty,
    //                 'unit_id' => $validatedData['unit_id'][$index],
    //                 'description' => $validatedData['description'] ?? '',
    //                 'invoice_no' => $formattedInvoiceNumber,
    //                 'date' => $currentDate, // Automatically set the current date and time
    //                 'created_at' => now(), // Assuming you have timestamps in your table
    //                 'updated_at' => now(), // Assuming you have timestamps in your table
    //                 'status' => 0, // Setting the status field to 0
    //             ];
    //             // Add item to aggregated items array
    //             $aggregatedItems[] = [
    //                 'category_id' => $validatedData['category_id'][$index],
    //                 'sub_category' => $validatedData['sub_category'][$index],
    //                 'item_id' => $item->id,
    //                 'sizes' => $validatedData['sizes'][$index],
    //                 'qty' => $requestedQty,
    //                 'unit_id' => $validatedData['unit_id'][$index],
    //                 'description' => $validatedData['description'] ?? '',
    //                 'status' => 0,
    //             ];
    //         }
    //         IssueItemOut::insert($issueItems);
    //         // Insert aggregated issue items
    //         AggregatedIssueItem::create([
    //             'uuid' => (string) Str::uuid(),
    //             'invoice_no' => $formattedInvoiceNumber,
    //             'items' => json_encode($aggregatedItems),
    //         ]);
    //         DB::commit();
    //         $notification = [
    //             'message' => 'Items issued successfully.',
    //             'alert-type' => 'success',
    //         ];
    //         return redirect()->back()->with($notification);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         // Log the exception message
    //         Log::error('Error issuing items: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'An error occurred while issuing items. Please try again.']);
    //     }

    // }
    public function edit($uuid)
    {
        try {
            $aggregatedItem = AggregatedIssueItem::where('uuid', $uuid)->firstOrFail();

            // Fetch item names using ITEM_IDs from the items array
            $itemsArray = is_string($aggregatedItem->items) ? json_decode($aggregatedItem->items, true) : $aggregatedItem->items;
            $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
            $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

            // Pass $aggregatedItem and $itemNames to your view for editing
            return view('Issueitemout.edit_item', compact('aggregatedItem', 'itemNames'));
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., ModelNotFoundException)
            return redirect()->route('issue-item-index')->with('error', 'Item not found.');
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'confirm_qty.*' => 'required|integer|min:1',
            'remarks.*' => 'required|string|max:255',
            'item_data.*.ITEM_ID' => 'required|exists:items,id',
            'item_data.*.STATUS' => 'required|in:0,1',
            'uuid' => 'required|exists:aggregated_issue_items,uuid',
        ]);

        DB::beginTransaction();

        try {
            // Fetch the AggregatedIssueItem
            $aggregatedItem = AggregatedIssueItem::where('uuid', $validatedData['uuid'])
                ->firstOrFail();

            // Update items attribute in AggregatedIssueItem
            $updatedItems = collect($aggregatedItem->items)->map(function ($item, $index) use ($validatedData) {
                foreach ($validatedData['item_data'] as $dataIndex => $itemData) {
                    if ($item['ITEM_ID'] == $itemData['ITEM_ID']) {
                        $item['STATUS'] = 1; // Set STATUS to 1
                        $item['CONFIRM_QTY'] = $validatedData['confirm_qty'][$dataIndex];
                        $item['REMARKS'] = $validatedData['remarks'][$dataIndex];
                        $item['confirmed_issued'] = now(); // Set confirmed_issued to current date
                        break;
                    }
                }
                return $item;
            });

            // Convert updated items back to JSON and save
            $aggregatedItem->items = $updatedItems->toArray();
            $aggregatedItem->save();

            // Update IssueItemOut records
            foreach ($validatedData['item_data'] as $index => $itemData) {
                $issueItem = IssueItemOut::where('item_id', $itemData['ITEM_ID'])
                    ->where('invoice_no', $aggregatedItem->invoice_no)
                    ->firstOrFail();

                $issueItem->confirm_qty = $validatedData['confirm_qty'][$index];
                $issueItem->remarks = $validatedData['remarks'][$index];
                $issueItem->status = 1; // Update status to 1
                $issueItem->confirmed_issued = now(); // Set confirmed_issued to current date
                $issueItem->save();
            }

            DB::commit();

            $notification = [
                'message' => 'Items updated successfully.',
                'alert-type' => 'success',
            ];
            return redirect()->route('all-items-confirmed-issued')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();
            $errorMessage = "Failed to update items: " . $e->getMessage();
            return back()->withErrors(['error' => $errorMessage]);
        }
    }

    public function generatePdf($uuid)
    {
        // Obtain the authenticated user
        $authenticatedUser = Auth::user();

        // Check if user is authenticated
        if ($authenticatedUser) {
            // Retrieve the item based on UUID
            $item = AggregatedIssueItem::where('uuid', $uuid)->first();

            if ($item) {
                // Decode items JSON if it's a string
                $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

                // Fetch item names using ITEM_IDs from the items array
                $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
                $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

                // Transform each item data into a structured format for display
                $formattedItems = collect($itemsArray)->map(function ($data) use ($itemNames) {
                    $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item';
                    $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';
                    // Build the details for each item
                    return [
                        'Category' => $data['CATEGORY_ID'],
                        'Sub Category' => $data['SUB_CATEGORY'],
                        'Item Name' => $itemName,
                        'Size' => $data['SIZES'],
                        'Quantity' => $data['QTY'],
                        'Unit ID' => $data['UNIT_ID'],
                        'Confirm Qty' => $data['CONFIRM_QTY'],
                        'Remarks' => $data['REMARKS'],
                        'Description' => $data['DESCRIPTION'] ?? '',
                        'confirmed_issued' => \Carbon\Carbon::parse($data['confirmed_issued'])->format('d F Y'),
                        'STATUS' => $status,
                        'CREATED_BY' => $data['CREATED_BY'], // Include CREATED_BY here
                    ];
                });
                // Static address
                $address = '123 Main Street, Anytown, USA';
                // Fetch user who created the item
                $createdByUser = User::find($item->created_by);
                $createdByName = $createdByUser ? $createdByUser->name : 'Unknown User';

                // Prepare data for the PDF view
                $data = [
                    'uuid' => $item->uuid,
                    'invoice_no' => $item->invoice_no,
                    'items' => $formattedItems,
                    'issued_by' => $createdByName, // Use created by user name
                    'date_issued' => \Carbon\Carbon::parse($item->created_at)->format('d F Y'),
                    'address' => $address,
                    'signature' => $authenticatedUser->name, // Signature by authenticated user
                    'created_by' => $createdByName, // Pass created by user name to the view
                ];
                // Load the PDF view and stream it to the user
                $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'portrait');
                return $pdf->stream('item-issued.pdf');
            }
            return redirect()->back()->with('error', 'Item not found');
        }
        return redirect()->back()->with('error', 'Unauthorized access');
    }

    // public function update(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'confirm_qty.*' => 'required|integer|min:1',
    //         'remarks.*' => 'required|string|max:255',
    //         'item_data.*.ITEM_ID' => 'required|exists:items,id',
    //         'item_data.*.STATUS' => 'required|in:0,1',
    //         'uuid' => 'required|exists:aggregated_issue_items,uuid',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         // Fetch the AggregatedIssueItem
    //         $aggregatedItem = AggregatedIssueItem::where('uuid', $validatedData['uuid'])
    //             ->firstOrFail();
    //         // Update items attribute in AggregatedIssueItem
    //         $updatedItems = collect($aggregatedItem->items)->map(function ($item, $index) use ($validatedData) {
    //             foreach ($validatedData['item_data'] as $dataIndex => $itemData) {
    //                 if ($item['ITEM_ID'] == $itemData['ITEM_ID']) {
    //                     $item['STATUS'] = 1; // Set STATUS to 1
    //                     $item['CONFIRM_QTY'] = $validatedData['confirm_qty'][$dataIndex];
    //                     $item['REMARKS'] = $validatedData['remarks'][$dataIndex];
    //                     break;
    //                 }
    //             }
    //             return $item;
    //         });

    //         // Convert updated items back to JSON and save
    //         $aggregatedItem->items = $updatedItems->toArray();
    //         $aggregatedItem->save();

    //         // Update IssueItemOut records
    //         foreach ($validatedData['item_data'] as $index => $itemData) {
    //             $issueItem = IssueItemOut::where('item_id', $itemData['ITEM_ID'])
    //                 ->where('invoice_no', $aggregatedItem->invoice_no)
    //                 ->firstOrFail();

    //             $issueItem->confirm_qty = $validatedData['confirm_qty'][$index];
    //             $issueItem->remarks = $validatedData['remarks'][$index];
    //             $issueItem->status = 1; // Update status to 1
    //             $issueItem->save();
    //         }

    //         DB::commit();

    //         $notification = [
    //             'message' => 'Items updated successfully.',
    //             'alert-type' => 'success',
    //         ];
    //         return redirect()->route('dashboard')->with($notification);
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         $errorMessage = "Failed to update items: " . $e->getMessage();
    //         return back()->withErrors(['error' => $errorMessage]);
    //     }
    // }
    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Fetch user who created the item
    //         $createdBy = User::find($item->created_by);
    //         $createdByName = $createdBy ? $createdBy->name : 'Unknown User';

    //         // Static address
    //         $address = '123 Main Street, Anytown, USA';

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item';
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //                 'Description' => $data['DESCRIPTION'] ?? '',
    //                 'confirmed_issued' => \Carbon\Carbon::parse($data['confirmed_issued'])->format('Y-m-d'),
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //             'issued_by' => $createdByName,
    //             'date_issued' => \Carbon\Carbon::parse($item->created_at)->format('Y-m-d'),
    //             'address' => $address,
    //             'signature' => $createdByName,
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'portrait');

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Fetch user who created the item
    //         $createdBy = User::find($item->created_by);
    //         $createdByName = $createdBy ? $createdBy->name : 'Unknown User';

    //         // Static address
    //         $address = '123 Main Street, Anytown, USA';

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item';
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //                 'Description' => $data['DESCRIPTION'] ?? '',
    //                 'confirmed_issued' => \Carbon\Carbon::parse($data['confirmed_issued'])->format('d F Y'),
    //                 'STATUS' => $status,
    //                 'CREATED_BY' => $data['CREATED_BY'],
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //             'issued_by' => $createdByName,
    //             'date_issued' => \Carbon\Carbon::parse($item->created_at)->format('d F Y'),
    //             'address' => $address,
    //             'signature' => $createdByName,
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'portrait');

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

    //newwest one
    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Fetch user who created the item
    //         $createdBy = User::find($item->created_by);
    //         $createdByName = $createdBy ? $createdBy->name : 'Unknown User';

    //         // Static address
    //         $address = '123 Main Street, Anytown, USA';

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item';
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //                 'Description' => $data['DESCRIPTION'] ?? '',
    //                 'confirmed_issued' => \Carbon\Carbon::parse($data['confirmed_issued'])->format('d F Y'),
    //                 'STATUS' => $status,
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //             'issued_by' => $createdByName,
    //             'date_issued' => \Carbon\Carbon::parse($item->created_at)->format('d F Y'),
    //             'address' => $address,
    //             'signature' => $createdByName,
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'portrait');

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

//latest pdf
    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Description' => $data['DESCRIPTION'],
    //                 'Status' => $status,
    //                 'Invoice No' => $data['INVOICE_NO'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //             'issued_by' => 'Great Logic', // Replace with actual issuer
    //             'date_issued' => date('Y-m-d'), // Replace with actual issue date if available
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'portrait');

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Description' => $data['DESCRIPTION'],
    //                 'Status' => $status,
    //                 'Invoice No' => $data['INVOICE_NO'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //             'issued_by' => 'John Doe', // Replace with actual issuer
    //             'date_issued' => date('Y-m-d'), // Replace with actual issue date if available
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data)->setPaper('a4', 'landscape');

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

    // public function generatePdf($uuid)
    // {
    //     $item = AggregatedIssueItem::where('uuid', $uuid)->first();

    //     if ($item) {
    //         $itemsArray = is_string($item->items) ? json_decode($item->items, true) : $item->items;

    //         // Fetch item names using ITEM_IDs from the items array
    //         $itemIds = collect($itemsArray)->pluck('ITEM_ID')->unique()->toArray();
    //         $itemNames = Item::whereIn('id', $itemIds)->pluck('item_name', 'id');

    //         // Transform each item data into a structured format for display
    //         $formattedItems = collect($itemsArray)->map(function ($data, $index) use ($itemNames) {
    //             $itemName = $itemNames[$data['ITEM_ID']] ?? 'Unknown Item'; // Fetch item name based on ITEM_ID
    //             $status = $data['STATUS'] == 1 ? 'Issuance Issued' : 'Pending';

    //             // Build the details for each item
    //             $itemDetails = [
    //                 'Category' => $data['CATEGORY_ID'],
    //                 'Sub Category' => $data['SUB_CATEGORY'],
    //                 'Item Name' => $itemName,
    //                 'Size' => $data['SIZES'],
    //                 'Quantity' => $data['QTY'],
    //                 'Unit ID' => $data['UNIT_ID'],
    //                 'Description' => $data['DESCRIPTION'],
    //                 'Status' => $status,
    //                 'Invoice No' => $data['INVOICE_NO'],
    //                 'Confirm Qty' => $data['CONFIRM_QTY'],
    //                 'Remarks' => $data['REMARKS'],
    //             ];

    //             return $itemDetails;
    //         });

    //         $data = [
    //             'uuid' => $item->uuid,
    //             'invoice_no' => $item->invoice_no,
    //             'items' => $formattedItems,
    //         ];

    //         $pdf = PDF::loadView('pdf.item_issued', $data);

    //         return $pdf->stream('item-issued.pdf');
    //     }

    //     return redirect()->back()->with('error', 'Item not found');
    // }

    // public function update(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'confirm_qty.*' => 'required|integer|min:1',
    //         'remarks.*' => 'required|string|max:255',
    //         'item_data.*.ITEM_ID' => 'required|exists:items,id',
    //         'item_data.*.STATUS' => 'required|in:0,1',
    //         'uuid' => 'required|exists:aggregated_issue_items,uuid',
    //     ]);

    //     $aggregatedItem = AggregatedIssueItem::where('uuid', $validatedData['uuid'])
    //         ->firstOrFail();

    //     // Update items attribute in AggregatedIssueItem
    //     $updatedItems = collect($aggregatedItem->items)->map(function ($item, $index) use ($validatedData) {
    //         foreach ($validatedData['item_data'] as $dataIndex => $itemData) {
    //             if ($item['ITEM_ID'] == $itemData['ITEM_ID']) {
    //                 $item['STATUS'] = 1; // Set STATUS to 1
    //                 $item['CONFIRM_QTY'] = $validatedData['confirm_qty'][$dataIndex];
    //                 $item['REMARKS'] = $validatedData['remarks'][$dataIndex];
    //                 break;
    //             }
    //         }
    //         return $item;
    //     });

    //     // Convert updated items back to JSON and save
    //     $aggregatedItem->items = $updatedItems->toArray();
    //     $aggregatedItem->save();
    //     // Update IssueItemOut records
    //     foreach ($validatedData['item_data'] as $index => $itemData) {
    //         $issueItem = IssueItemOut::where('item_id', $itemData['ITEM_ID'])
    //             ->where('invoice_no', $aggregatedItem->invoice_no)
    //             ->firstOrFail();
    //         $issueItem->confirm_qty = $validatedData['confirm_qty'][$index];
    //         $issueItem->remarks = $validatedData['remarks'][$index];
    //         $issueItem->status = 1; // Update status to 1
    //         $issueItem->save();
    //     }
    //     $notification = [
    //         'message' => 'Items updated successfully.',
    //         'alert-type' => 'success',
    //     ];
    //     return redirect()->route('dashboard')->with($notification);
    // }

    public function item_issued_out_delete($uuid)
    {
        // Find the restock record by UUID
        $itemissued = IssueItemOut::where('uuid', $uuid)->first();
        if (!$itemissued) {
            abort(404);
        }
        // Start a transaction
        DB::transaction(function () use ($itemissued) {
            // Find the related item
            $item = Item::find($itemissued->item_id);
            if ($item) {
                // Subtract the itemissueded quantity from the item's stock
                $item->qty += $itemissued->qty;
                $item->save();
            }
            // Delete the itemissued record
            $itemissued->delete();
        });
        // Return with a success notification
        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
