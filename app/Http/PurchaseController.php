<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
class PurchaseController extends Controller
{
    public function View(){
        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('Purchases.index',compact('allData'));
    }
    Public function Add(){
        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();
        return view('Purchases.create',compact('supplier','unit','category'));
    }
    
    public function Store(Request $request){
        if ($request->category_id == null) {

            $notification = array(
             'message' => 'Sorry you do not select any item', 
             'alert-type' => 'error'
         );
         return redirect()->back( )->with($notification);
         } else {
     
             $count_category = count($request->category_id);
             for ($i=0; $i < $count_category; $i++) { 
                 $purchase = new Purchase();
                 $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                 $purchase->purchase_no = $request->purchase_no[$i];
                 $purchase->supplier_id = $request->supplier_id[$i];
                 $purchase->category_id = $request->category_id[$i];
     
                 $purchase->product_id = $request->product_id[$i];
                 $purchase->buying_qty = $request->buying_qty[$i];
                 $purchase->unit_price = $request->unit_price[$i];
                 $purchase->buying_price = $request->buying_price[$i];
                 $purchase->description = $request->description[$i];
     
                 $purchase->created_by = Auth::user()->id;
                 $purchase->status = '0';
                 $purchase->save();
             } // end foreach
         } // end else 
     
         $notification = array(
             'message' => 'Data Save Successfully', 
             'alert-type' => 'success'
         );
         return redirect()->route('purview')->with($notification); 
    }
    public function Delete($id){
        Purchase::findOrFail($id)->delete();

        $notification = array(
       'message' => 'Purchase Iteam Deleted Successfully', 
       'alert-type' => 'success'
   );
   return redirect()->back()->with($notification); 
    }
    Public function Pending(){
        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('Purchases.pending',compact('allData'));
    }
    public function Approve($id){
        $purchase = Purchase::findOrFail($id);
        $product = Product::where('id',$purchase->product_id)->first();
        $purchase_qty = ((float)($purchase->buying_qty))+((float)($product->quantity));
        $product->quantity = $purchase_qty;

        if($product->save()){

            Purchase::findOrFail($id)->update([
                'status' => '1',
            ]);

             $notification = array(
        'message' => 'Status Approved Successfully', 
        'alert-type' => 'success'
          );
    return redirect()->route('purview')->with($notification); 

        }
    }
}
