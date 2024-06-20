<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\AggregatedIssueItem;
use App\Models\Category;
use App\Models\IssueItemOut;
use App\Models\Item;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request; // Import DB facade for transactions
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IssueItemOutController extends Controller
{
    public function index()
    {
        return view('Issueitemout.index');
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
            'sizes' => 'required|array',
            'qty' => 'required|array',
            'unit_id' => 'required|array',
            'description' => 'nullable|string',
            'invoice_no' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Fetch the last invoice number and increment it
            $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
            $lastInvoiceNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_no, FILTER_SANITIZE_NUMBER_INT) : 0;
            $newInvoiceNumber = $lastInvoiceNumber + 1;
            $formattedInvoiceNumber = 'INVOICE-NO-' . $newInvoiceNumber . '-' . now()->year;

            $issueItems = [];
            $currentDate = now();
            $aggregatedItems = []; // Array to hold aggregated items data
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
                // Add the issue item to the array
                $issueItems[] = [
                    'uuid' => (string) Str::uuid(), // Generate a UUID for each record
                    'category_id' => $validatedData['category_id'][$index],
                    'sub_category' => $validatedData['sub_category'][$index],
                    'item_id' => $item->id, // Storing item ID instead of name
                    'sizes' => $validatedData['sizes'][$index],
                    'qty' => $requestedQty,
                    'unit_id' => $validatedData['unit_id'][$index],
                    'description' => $validatedData['description'] ?? '',
                    'invoice_no' => $formattedInvoiceNumber,
                    'date' => $currentDate, // Automatically set the current date and time
                    'created_at' => now(), // Assuming you have timestamps in your table
                    'updated_at' => now(), // Assuming you have timestamps in your table
                    'status' => 0, // Setting the status field to 0
                ];
                // Add item to aggregated items array
                $aggregatedItems[] = [
                    'category_id' => $validatedData['category_id'][$index],
                    'sub_category' => $validatedData['sub_category'][$index],
                    'item_id' => $item->id,
                    'sizes' => $validatedData['sizes'][$index],
                    'qty' => $requestedQty,
                    'unit_id' => $validatedData['unit_id'][$index],
                    'description' => $validatedData['description'] ?? '',
                ];
            }
            IssueItemOut::insert($issueItems);
            // Insert aggregated issue items
            AggregatedIssueItem::create([
                'uuid' => (string) Str::uuid(),
                'invoice_no' => $formattedInvoiceNumber,
                'items' => json_encode($aggregatedItems),
            ]);
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

        // try {
        //     DB::beginTransaction();

        //     // Fetch the last invoice number and increment it
        //     $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
        //     $lastInvoiceNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_no, FILTER_SANITIZE_NUMBER_INT) : 0;
        //     $newInvoiceNumber = $lastInvoiceNumber + 1;
        //     $formattedInvoiceNumber = 'INVOICE-NO-' . $newInvoiceNumber . '-' . now()->year;

        //     $issueItems = [];
        //     $currentDate = now();

        //     foreach ($validatedData['item_id'] as $index => $itemName) {
        //         $item = Item::where('item_name', $itemName)->first();
        //         if (!$item) {
        //             return back()->withErrors(['item_id' => "Item $itemName not found."]);
        //         }
        //         $requestedQty = $validatedData['qty'][$index];
        //         if ($requestedQty > $item->qty) {
        //             return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
        //         }

        //         // Subtract the quantity from the item
        //         $item->qty -= $requestedQty;
        //         $item->save();

        //         // Add the issue item to the array
        //         $issueItems[] = [
        //             'uuid' => (string) Str::uuid(), // Generate a UUID for each record
        //             'category_id' => $validatedData['category_id'][$index],
        //             'sub_category' => $validatedData['sub_category'][$index],
        //             'item_id' => $item->id, // Storing item ID instead of name
        //             'sizes' => $validatedData['sizes'][$index],
        //             'qty' => $requestedQty,
        //             'unit_id' => $validatedData['unit_id'][$index],
        //             'description' => $validatedData['description'] ?? '',
        //             'invoice_no' => $formattedInvoiceNumber,
        //             'date' => $currentDate, // Automatically set the current date and time
        //             'created_at' => now(), // Assuming you have timestamps in your table
        //             'updated_at' => now(), // Assuming you have timestamps in your table
        //             'status' => 0, // Setting the status field to 0
        //         ];
        //     }
        //     // Insert all issue items at once
        //     IssueItemOut::insert($issueItems);
        //     DB::commit();
        //     $notification = [
        //         'message' => 'Items issued successfully.',
        //         'alert-type' => 'success',
        //     ];

        //     return redirect()->back()->with($notification);
        // } catch (Exception $e) {
        //     DB::rollBack();

        //     // Log the exception message
        //     Log::error('Error issuing items: ' . $e->getMessage());

        //     return back()->withErrors(['error' => 'An error occurred while issuing items. Please try again.']);
        // }

        // try {
        //     DB::beginTransaction();
        //     // Fetch the last invoice number and increment it
        //     $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
        //     $newInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_no + 1 : 1;
        //     $issueItems = [];
        //     $currentDate = now();
        //     foreach ($validatedData['item_id'] as $index => $itemName) {
        //         $item = Item::where('item_name', $itemName)->first();
        //         if (!$item) {
        //             return back()->withErrors(['item_id' => "Item $itemName not found."]);
        //         }
        //         $requestedQty = $validatedData['qty'][$index];
        //         if ($requestedQty > $item->qty) {
        //             return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
        //         }
        //         // Subtract the quantity from the item
        //         $item->qty -= $requestedQty;
        //         $item->save();
        //         // Add the issue item to the array
        //         $issueItems[] = [
        //             'uuid' => (string) Str::uuid(), // Generate a UUID for each record
        //             'category_id' => $validatedData['category_id'][$index],
        //             'sub_category' => $validatedData['sub_category'][$index],
        //             'item_id' => $item->id, // Storing item ID instead of name
        //             'sizes' => $validatedData['sizes'][$index],
        //             'qty' => $requestedQty,
        //             'unit_id' => $validatedData['unit_id'][$index],
        //             'description' => $validatedData['description'] ?? '',
        //             'invoice_no' => $newInvoiceNumber,
        //             'date' => $currentDate, // Automatically set the current date and time
        //             'created_at' => now(), // Assuming you have timestamps in your table
        //             'updated_at' => now(), // Assuming you have timestamps in your table
        //         ];
        //     }
        //     // Insert all issue items at once
        //     IssueItemOut::insert($issueItems);
        //     DB::commit();
        //     $notification = [
        //         'message' => 'Items issued successfully.',
        //         'alert-type' => 'success',
        //     ];
        //     return redirect()->back()->with($notification);
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     // Log the exception message
        //     Log::error('Error issuing items: ' . $e->getMessage());
        //     return back()->withErrors(['error' => 'An error occurred while issuing items. Please try again.']);
        // }
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

    //     // Fetch the last invoice number and increment it
    //     $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
    //     $newInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_no + 1 : 1;

    //     $issueItems = [];
    //     $currentDate = now();

    //     foreach ($validatedData['item_id'] as $index => $itemName) {
    //         $item = Item::where('item_name', $itemName)->first();

    //         if (!$item) {
    //             return back()->withErrors(['item_id' => "Item $itemName not found."]);
    //         }

    //         $requestedQty = $validatedData['qty'][$index];

    //         if ($requestedQty > $item->qty) {
    //             return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
    //         }

    //         // Subtract the quantity from the item
    //         $item->qty -= $requestedQty;
    //         $item->save();

    //         // Add the issue item to the array
    //         $issueItems[] = [
    //             'uuid' => (string) Str::uuid(), // Generate a UUID for each record
    //             'category_id' => $validatedData['category_id'][$index],
    //             'sub_category' => $validatedData['sub_category'][$index],
    //             'item_id' => $item->id, // Storing item ID instead of name
    //             'sizes' => $validatedData['sizes'][$index],
    //             'qty' => $requestedQty,
    //             'unit_id' => $validatedData['unit_id'][$index],
    //             'description' => $validatedData['description'] ?? '',
    //             'invoice_no' => $newInvoiceNumber,
    //             'date' => $currentDate, // Automatically set the current date and time
    //             'created_at' => now(), // Assuming you have timestamps in your table
    //             'updated_at' => now(), // Assuming you have timestamps in your table
    //         ];
    //     }

    //     // Insert all issue items at once
    //     IssueItemOut::insert($issueItems);

    //     return redirect()->back()->with('success', 'Items issued successfully.');
    // }
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

    //     // Fetch the last invoice number and increment it
    //     $lastInvoice = IssueItemOut::orderBy('invoice_no', 'desc')->first();
    //     $newInvoiceNumber = $lastInvoice ? $lastInvoice->invoice_no + 1 : 1;

    //     $issueItems = [];
    //     $currentDate = now();

    //     foreach ($validatedData['item_id'] as $index => $itemName) {
    //         $item = Item::where('item_name', $itemName)->first();

    //         if (!$item) {
    //             return back()->withErrors(['item_id' => "Item $itemName not found."]);
    //         }

    //         $requestedQty = $validatedData['qty'][$index];

    //         if ($requestedQty > $item->qty) {
    //             return back()->withErrors(['qty' => "Requested quantity for $itemName is more than available quantity."]);
    //         }

    //         // Subtract the quantity from the item
    //         $item->qty -= $requestedQty;
    //         $item->save();

    //         // Add the issue item to the array
    //         $issueItems[] = [
    //             'category_id' => $validatedData['category_id'][$index],
    //             'sub_category' => $validatedData['sub_category'][$index],
    //             'item_id' => $item->id, // Storing item ID instead of name
    //             'sizes' => $validatedData['sizes'][$index],
    //             'qty' => $requestedQty,
    //             'unit_id' => $validatedData['unit_id'][$index],
    //             'description' => $validatedData['description'] ?? '',
    //             'invoice_no' => $newInvoiceNumber,
    //             'date' => $currentDate, // Automatically set the current date and time
    //             'created_at' => now(), // Assuming you have timestamps in your table
    //             'updated_at' => now(), // Assuming you have timestamps in your table
    //         ];
    //     }

    //     // Insert all issue items at once
    //     IssueItemOut::insert($issueItems);

    //     return redirect()->back()->with('success', 'Items issued successfully.');
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
