<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase_Product;
use App\Models\Supplier;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PurchaseController extends Controller
{
    public function purchase_index()
    {

        $purchases = Purchase_Product::latest()->get();
        return view('Products_Purchase.index',compact('purchases'));
    }
    public function purchase_create()
    {
        $products = Product::orderBy('product_name', 'ASC')->get();
        $suppliers = Supplier::orderBy('supplier_name', 'ASC')->get();
        return view('Products_Purchase.create', compact('products', 'suppliers'));
    }
    public function purchase_store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'supplier_id' => 'required',
            'purchase_date' => 'required',
            'qty' => 'required'
        ]);

        if ($request->product_id == null) {
            $notification = array(
                'message' => 'Sorry You do not select any item',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        } else {
            $invoice = new Purchase_Product();
            $invoice->product_id = $request->product_id;
            $invoice->supplier_id = $request->supplier_id;
            $invoice->qty = $request->qty;
            $invoice->purchase_date = $request->purchase_date;
            $invoice->created_by = Auth::user()->id;

            DB::transaction(function () use ($request, $invoice) {
                if ($invoice->save()) {
                    $productupdateqty = Product::findOrFail($request->product_id);
                    $productupdateqty->qty += $request->qty;
                    $productupdateqty->save();
                }
            });
        }

        $notification = array(
            'message' => ' Inserted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewpurchase')->with($notification);
    }
    public function purchase_edit($id)
    {
        $sup = Supplier::all();
        $product = Product::all();
        $newpurchase = Purchase_Product::findOrFail($id);
     return view('Products_Purchase.edit',compact('sup','product','newpurchase'));
    }
    public function purchase_update(Request $request,$id)
    {

            $invoice = Purchase_Product::findOrFail($id);
            $invoice->product_id = $request->product_id;
            $invoice->supplier_id = $request->supplier_id;
            $invoice->qty = $request->qty;
            $invoice->purchase_date = $request->purchase_date;
            $invoice->updated_by = Auth::user()->id;

            DB::transaction(function () use ($request, $invoice) {
                if ($invoice->save()) {
                    $productupdateqty = Product::findOrFail($request->product_id);
                    $productupdateqty->qty += $request->qty;
                    $productupdateqty->update();
                }
            });
        $notification = array(
            'message' => ' Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewpurchase')->with($notification);
    }
    public function purchase_delete($id)
    {
        Purchase_Product::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

}
