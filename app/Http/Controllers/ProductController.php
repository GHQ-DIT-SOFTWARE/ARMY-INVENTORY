<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Electronic_Gadget;
use App\Models\NonElectronicItem;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function Routine()
    {
        return view('Products.show');
    }
    public function View()
    {

        $product = Electronic_Gadget::orderBy('product_name')
        ->orderBy('category_name')
        ->get();
        return view('Products.index', compact('product'));
    }
    public function serveandunser()
    {

        $allservqty = Electronic_Gadget::select('product_name', DB::raw('count(*) as count'))->where('status', 1)
            ->groupBy('product_name')
            ->get();
        $allunservqty = Electronic_Gadget::select('product_name', DB::raw('count(*) as count'))->where('status', 0)
            ->groupBy('product_name')
            ->get();
        return view('Products.serv_or_unser', compact('allservqty', 'allunservqty'));
    }
    public function Add()
    {
        $category = Category::all();
        return view('Products.create', compact('category'));
    }
    public function Store(Request $request)
    {
        $request->validate([
            'serial_no' =>'required|unique:electronic__gadgets',
            'item_image' =>'image|mimes:jpeg,png,jpg,gif,bmp,tiff,jfif|max:2048', // Allow additional formats
        ]);
        if ($request->file('item_image')) {
            $image = $request->file('item_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(200, 200)->save(public_path('uploadimage/user_images/' . $name_gen));
            $save_url = 'uploadimage/user_images/' . $name_gen;

            Electronic_Gadget::insert([
                'product_name' => $request->product_name,
                'serial_no' => $request->serial_no,
                'status' => $request->status,
                'state' => $request->state,
                'item_image' =>$save_url,
                'category_name' => $request->category_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Item Inserted Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        } else {
            Electronic_Gadget::insert([
                'product_name' => $request->product_name,
                'serial_no' => $request->serial_no,
                'status' => $request->status,
                'state' => $request->state,
                'category_name' => $request->category_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Item Inserted Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        }
    }
    public function Edit($id)
    {

        $category = Category::all();
        $product = Electronic_Gadget::findOrFail($id);
        return view('Products.edit', compact('product', 'category'));
    }

    public function Update(Request $request)
{
    $request->validate([
        'serial_no' =>'required|unique:electronic__gadgets',
        'item_image' =>'image|mimes:jpeg,png,jpg,gif,bmp,tiff,jfif|max:2048', // Allow additional formats
    ]);
    $product_id = $request->id;
    if ($request->file('item_image')) {
        $image = $request->file('item_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(200, 200)->save(public_path('uploadimage/user_images/' . $name_gen));
            $save_url = 'uploadimage/user_images/' . $name_gen;
        Electronic_Gadget::findOrFail($product_id)->update([
            'product_name' => $request->product_name,
            'serial_no' => $request->serial_no,
            // 'status' => $request->status,
            // 'state' => $request->state,
            'item_image' => $imagePath,
            'category_name' => $request->category_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Item Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewpro')->with($notification);
    } else {
        Electronic_Gadget::findOrFail($product_id)->update([
            'product_name' => $request->product_name,
            'serial_no' => $request->serial_no,
            // 'status' => $request->status,
            // 'state' => $request->state,
            'category_name' => $request->category_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Item Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewpro')->with($notification);
    }
}

    public function Delete($id)
    {
        Electronic_Gadget::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Item Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    public function Indexnon()
    {
        $non_electronic = NonElectronicItem::get();
        return view('Products.Non-Electronic-Item.index', compact('non_electronic'));
    }
    public function serveandunsernon()
    {
        $allservqty = NonElectronicItem::select('product_name', DB::raw('count(*) as count'))->where('status', 1)
            ->groupBy('product_name')
            ->get();
        $allunservqty = NonElectronicItem::select('product_name', DB::raw('count(*) as count'))->where('status', 0)
            ->groupBy('product_name')
            ->get();
        return view('Products.Non-Electronic-Item.serv_or_unser', compact('allservqty', 'allunservqty'));
    }
    public function Createnon()
    {
        $category = Category::all();
        return view('Products.Non-Electronic-Item.create', compact('category'));
    }
    public function Storenon(Request $request)
    {
        $request->validate([
            'body_no' => 'required|unique:non_electronic_items',
            'item_image' =>'image|mimes:jpeg,png,jpg,gif,bmp,tiff,jfif|max:2048', // Allow additional formats
        ]);
        if ($request->file('item_image')) {
            $image = $request->file('item_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(200, 200)->save(public_path('nonelectronics/user_images/' . $name_gen));
            $save_url = 'nonelectronics/user_images/' . $name_gen;
            NonElectronicItem::insert([
                'product_name' => $request->product_name,
                'body_no' => $request->body_no,
                'status' => $request->status,
                'state' => $request->state,
                'item_image' => $save_url,
                'category_name' => $request->category_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'General Item Inserted Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        } else {
            NonElectronicItem::insert([
                'product_name' => $request->product_name,
                'body_no' => $request->body_no,
                'status' => $request->status,
                'state' => $request->state,
                'category_name' => $request->category_name,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'General Item Inserted Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        }
    }
    public function Editnon($id)
    {
        $category = Category::all();
        $non_electronic = NonElectronicItem::findOrFail($id);
        return view('Products.Non-Electronic-Item.edit', compact('category', 'non_electronic'));
    }
    public function Updatenon(Request $request)
    {
        $request->validate([
            'body_no' => 'required|unique:non_electronic_items',
            'item_image' =>'image|mimes:jpeg,png,jpg,gif,bmp,tiff,jfif|max:2048', // Allow additional formats
        ]);
        $product_id = $request->id;
        if ($request->file('item_image')) {
            $image = $request->file('item_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(200, 200)->save(public_path('nonelectronics/user_images/' . $name_gen));
            $save_url = 'nonelectronics/user_images/' . $name_gen;
            NonElectronicItem::findOrFail($product_id)->update([
                'product_name' => $request->product_name,
                'body_no' => $request->body_no,
                // 'status' => $request->status,
                'item_location' => $request->item_location,
                'item_image' => $imagePath,
                'category_name' => $request->category_name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'General Item Updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        } else {
            NonElectronicItem::findOrFail($product_id)->update([
                'product_name' => $request->product_name,
                'body_no' => $request->body_no,
                //  'status' => $request->status,
                'item_location' => $request->item_location,
                'category_name' => $request->category_name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array(
                'message' => 'Item Updated Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        } // end else
    }
    public function Deletenon($id)
    {
        NonElectronicItem::findOrFail($id)->delete();
        $notification = array(
            'message' => ' Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    public function sernon()
    {
        $allData = NonElectronicItem::orderBy('id', 'desc')->where('status', '1')->get();
        return view('Products.Non-Electronic-Item.ser', compact('allData'));
    }
    public function sernonelec()
    {
        $allData = NonElectronicItem::orderBy('id', 'desc')->where('status', '0')->get();
        return view('Products.Non-Electronic-Item.unser', compact('allData'));
    }

    public function serelec()
    {
        $allData = Electronic_Gadget::orderBy('id', 'desc')->where('status', '1')->get();
        return view('Products.ser', compact('allData'));
    }
    public function sernonelectronic()
    {
        $allData = Electronic_Gadget::orderBy('id', 'desc')->where('status', '0')->get();
        return view('Products.unser', compact('allData'));
    }
    public function Approve($id)
    {
        $allData = Electronic_Gadget::findOrFail($id);
        if ($allData) {
            $allData->status = 0;
            $allData->save();
            $notification = array(
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        }
    }
    public function Rescheduled($id)
    {
        $allData = Electronic_Gadget::findOrFail($id);
        if ($allData) {
            $allData->status = 1;
            $allData->save();
            $notification = array(
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        }
    }
    public function Ser($id)
    {
        $allData = NonElectronicItem::findOrFail($id);
        if ($allData) {
            $allData->status = 0;
            $allData->save();
            $notification = array(
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        }
    }
    public function Unser($id)
    {
        $allData = NonElectronicItem::findOrFail($id);
        if ($allData) {
            $allData->status = 1;
            $allData->save();
            $notification = array(
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        }
    }
    public function alleachqt()
    {
        $totalProductsQty = Electronic_Gadget::select('product_name', 'category_name','state', DB::raw('count(*) as count'))
            ->groupBy('Product_name', 'category_name','state')->where('state',1)
            ->get();
        return view('Products.alleleqty', compact('totalProductsQty'));

    }
    public function alleachqtgeneralitem()
    {
        $totalProductsQty = NonElectronicItem::select('product_name', 'category_name', DB::raw('count(*) as count'))
            ->groupBy('Product_name', 'category_name')
            ->get();
        return view('Products.Non-Electronic-Item.alleleqty', compact('totalProductsQty'));

    }
    public function Electronicavailability($id)
    {
        $allData = Electronic_Gadget::findOrFail($id);
        if ($allData) {
            $allData->state = 0;
            $allData->save();
            $notification = array(
                'message' => 'State Changed Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        }
    }
    public function ElectronicUnavailability($id)
    {
        $allData = Electronic_Gadget::findOrFail($id);
        if ($allData) {
            $allData->state = 1;
            $allData->save();
            $notification = array(
                'message' => 'State Changed Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('viewpro')->with($notification);
        }
    }

    public function Generalavailability($id)
    {
        $allData = NonElectronicItem::findOrFail($id);
        if ($allData) {
            $allData->state = 0;
            $allData->save();
            $notification = array(
                'message' => 'State Changed Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        }
    }
    public function GeneralUnavailability($id)
    {
        $allData = NonElectronicItem::findOrFail($id);
        if ($allData) {
            $allData->state = 1;
            $allData->save();
            $notification = array(
                'message' => 'State Changed Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('view.nonpro')->with($notification);
        }
    }
    public function productsByCategory($id)
    {
        $categoryName = $id;

        $categoryItems = Electronic_Gadget::where('category_name', $id)
            ->select('product_name',
                DB::raw('SUM(CASE WHEN state = 1 THEN 1 ELSE 0 END) as available'),
                DB::raw('SUM(CASE WHEN state = 0 THEN 1 ELSE 0 END) as unavailable'),
                DB::raw('SUM(CASE WHEN state IN (0, 1) THEN 1 ELSE 0 END) as total'))
            ->groupBy('product_name')
            ->get();
        $relatedItems = NonElectronicItem::where('category_name', $id)
            ->select('product_name',
                DB::raw('SUM(CASE WHEN state = 1 THEN 1 ELSE 0 END) as available'),
                DB::raw('SUM(CASE WHEN state = 0 THEN 1 ELSE 0 END) as unavailable'),
                DB::raw('SUM(CASE WHEN state IN (0, 1) THEN 1 ELSE 0 END) as total'))
            ->groupBy('product_name')
            ->get();

        if ($categoryItems->count() > 0 || $relatedItems->count() > 0) {
            $message = 'Search results found.';
            $alertType = 'success';
        } else {
            $message = 'No Items found for this category.';
            $alertType = 'warning';
        }

        return view('Products.showdetail', compact('categoryItems', 'relatedItems', 'message', 'alertType'));
    }

}
