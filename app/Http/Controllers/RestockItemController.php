<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Restock;
use App\Models\Supplier;
use Auth;
use DB;
use Illuminate\Http\Request;

class RestockItemController extends Controller
{
    public function purchase_index()
    {
        $purchases = Restock::get();
        return view('restockitem.index', compact('purchases'));
    }
    public function purchase_create()
    {
        $category = Category::all();
        $products = Item::orderBy('item_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('company_name', 'ASC')->get();
        return view('restockitem.create', compact('products', 'suppliers', 'category'));
    }

    public function purchase_store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'qty' => 'required|integer|min:1',
            'sizes' => 'required',
            'restock_date' => 'required|date',
        ]);
        $existingItem = Item::where('id', $request->item_id)
            ->where('sizes', $request->sizes)
            ->first();
        if (!$existingItem) {
            $notification = [
                'message' => 'The selected item with the given size does not exist.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }

        DB::transaction(function () use ($request, $existingItem) {
            $existingItem->qty += $request->qty;
            $existingItem->save();

            $invoice = new Restock();
            $invoice->item_id = $request->item_id;
            $invoice->supplier_id = $request->supplier_id;
            $invoice->category_id = $request->category_id;
            $invoice->sub_category = $request->sub_category;
            $invoice->qty = $request->qty;
            $invoice->sizes = $request->sizes;
            $invoice->remarks = $request->remarks;
            $invoice->restock_date = Carbon::now();
            $invoice->created_by = Auth::user()->id;
            $invoice->save();
        });

        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('viewpurchase')->with($notification);
    }

    // public function purchase_store(Request $request)
    // {
    //     if ($request->item_id == null) {
    //         $notification = array(
    //             'message' => 'Sorry You do not select any item',
    //             'alert-type' => 'error',
    //         );
    //         return redirect()->back()->with($notification);
    //     } else {
    //         $invoice = new Restock();
    //         $invoice->item_id = $request->item_id;
    //         $invoice->supplier_id = $request->supplier_id;
    //         $invoice->qty = $request->qty;
    //         $invoice->restock_date = $request->restock_date;
    //         $invoice->created_by = Auth::user()->id;
    //         DB::transaction(function () use ($request, $invoice) {
    //             if ($invoice->save()) {
    //                 $productupdateqty = Item::findOrFail($request->item_id);
    //                 $productupdateqty->qty += $request->qty;
    //                 $productupdateqty->save();
    //             }
    //         });
    //     }
    //     $notification = array(
    //         'message' => 'Inserted Successfully',
    //         'alert-type' => 'success',
    //     );
    //     return redirect()->route('viewpurchase')->with($notification);
    // }
  
    public function purchase_delete($id)
    {
        Restock::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

}
