<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

// use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class ItemsController extends Controller
{

    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    public function View()
    {
        return view('items.index');
    }

    public function manage_item()
    {
        return view('inventory.items.item_manager');
    }

    public function serveandunser()
    {
        $allservqty = Item::select('item_name', DB::raw('count(*) as count'))->where('status', 1)
            ->groupBy('item_name')
            ->get();
        $allunservqty = Item::select('item_name', DB::raw('count(*) as count'))->where('status', 0)
            ->groupBy('item_name')
            ->get();
        return view('inventory.items.serv_or_unser', compact('allservqty', 'allunservqty'));
    }

    public function Add()
    {
        $category = Category::all();
        return view('items.create', compact('category'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'serial_no' => 'required|unique:items',
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category' => 'required',
            'qty' => 'required|integer',
            'sizes' => 'required',
            'image' => 'nullable|image',
        ]);
        // Check if an item with the same category, sub-category, item name, and size already exists
        $existingItem = Item::where('category_id', $request->category_id)
            ->where('sub_category', $request->sub_category)
            ->where('item_name', $request->item_name)
            ->where('sizes', $request->sizes)
            ->first();
        if ($existingItem) {
            return redirect()->back()->withErrors(['sizes' => 'An item with the same size already exists.']);
        }

        if ($request->file('image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img = $img->resize(200, 200);
            $img->save(public_path('uploadimage/Item_images/' . $name_gen));
            $save_url = 'uploadimage/Item_images/' . $name_gen;
        } else {
            $save_url = null;
        }
        $item = Item::create([
            'sub_category' => $request->sub_category,
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'qty' => $request->qty,
            'sizes' => $request->sizes,
            'added_date' => Carbon::now(),
            'remarks' => $request->remarks,
            'image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Item Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-item')->with($notification);
    }

    public function Edit($uuid)
    {
        $category = Category::all();
        $product = Item::where('uuid', $uuid)->first();
        if (!$product) {
            abort(404);
        }
        return view('items.edit', compact('product', 'category'));
    }

    public function Update(Request $request)
    {
        $product_id = $request->uuid;
        if ($request->file('item_image')) {
            $image = $request->file('item_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(200, 200)->save('uploadimage/Item_images/' . $name_gen);
            $save_url = 'uploadimage/Item_images/' . $name_gen;
            $product = Item::where('uuid', $product_id)->first();
            $product->update([
                'serial_no' => $request->serial_no,
                'type_own' => $request->type_own,
                'sub_category' => $request->sub_category,
                'item_name' => $request->item_name,
                'item_description' => $request->item_description,
                'weight' => $request->weight,
                'location' => $request->location,
                'item_value' => $request->item_value,
                'mission_id' => $request->mission_id,
                'initial_cost' => $request->initial_cost,
                'brand' => $request->brand,
                'un_no' => $request->un_no,
                'engine_no' => $request->engine_no,
                'date_of_manufacture' => $request->date_of_manufacture,
                'un_shelf_life' => $request->un_shelf_life,
                'color' => $request->color,
                'date_of_manufacture' => $request->date_of_manufacture,
                'added_date' => date('Y-m-d', strtotime($request->added_date)),
                'un_shelf_life' => $request->un_shelf_life,
                'cause_of_unsvc' => $request->cause_of_unsvc,
                'date_of_unserviceable' => $request->date_of_unserviceable,
                'status' => $request->status,
                'state' => $request->state,
                'item_image' => $save_url,
                'category_id' => $request->category_id,
                'updated_by' => Auth::user()->id,
            ]);
            $notification = [
                'message' => 'Item Updated Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('view-item')->with($notification);
        } else {
            $product = Item::where('uuid', $product_id)->first();
            $product->update([
                'serial_no' => $request->serial_no,
                'type_own' => $request->type_own,
                'sub_category' => $request->sub_category,
                'item_name' => $request->item_name,
                'item_description' => $request->item_description,
                'weight' => $request->weight,
                'location' => $request->location,
                'item_value' => $request->item_value,
                'mission_id' => $request->mission_id,
                'initial_cost' => $request->initial_cost,
                'brand' => $request->brand,
                'un_no' => $request->un_no,
                'engine_no' => $request->engine_no,
                'date_of_manufacture' => $request->date_of_manufacture,
                'color' => $request->color,
                'date_of_manufacture' => $request->date_of_manufacture,
                'added_date' => date('Y-m-d', strtotime($request->added_date)),
                'un_shelf_life' => $request->un_shelf_life,
                'cause_of_unsvc' => $request->cause_of_unsvc,
                'date_of_unserviceable' => $request->date_of_unserviceable,
                'status' => $request->status,
                'state' => $request->state,
                'category_id' => $request->category_id,
                'updated_by' => Auth::user()->id,
            ]);
            $notification = [
                'message' => 'Item Updated Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('view-item')->with($notification);
        }
    }

    public function Delete($uuid)
    {
        if (is_null($this->user) || !$this->user->can('logistic.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Logistic !');
        }
        $delete_item = Item::where('uuid', $uuid)->first();
        if (!$delete_item) {
            abort(404);
        }
        $delete_item->delete();
        $notification = [
            'message' => 'Item Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }

    // public function serelec()
    // {
    //     $allData = Item::orderBy('id', 'desc')->where('status', '1')->get();
    //     return view('inventory.items.ser', compact('allData'));
    // }

    // public function sernonelectronic()
    // {
    //     $allData = Item::orderBy('id', 'desc')->where('status', '0')->get();
    //     return view('inventory.items.unser', compact('allData'));
    // }

    public function Serviceable()
    {
        if (is_null($this->user) || !$this->user->can('logistic.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Logistic !');
        }
        return view('inventory.items.ser');
    }
    public function Un_Serviceable()
    {
        if (is_null($this->user) || !$this->user->can('logistic.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Logistic !');
        }
        return view('inventory.items.unserviceable');
    }
    public function Approve($id)
    {
        $allData = Item::findOrFail($id);
        if ($allData) {
            $allData->status = 0;
            $allData->save();
            $notification = [
                'message' => 'Status Approved Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('view-item')->with($notification);
        }
    }

    public function alleachqt()
    {
        if (is_null($this->user) || !$this->user->can('logistic.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Logistic !');
        }
        $totalitemsQty = Item::select('item_name', 'category_id', 'state', DB::raw('count(*) as count'))
            ->groupBy('item_name', 'category_id', 'state')->where('state', 1)
            ->get();
        return view('inventory.items.alleleqty', compact('totalitemsQty'));
    }

    public function itemsByCategory($uuid)
    {
        if (is_null($this->user) || !$this->user->can('logistic.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Logistic !');
        }
        $category = Category::where('uuid', $uuid)->firstOrFail();
        $categoryItems = Item::where('category_id', $category->id)
            ->select(
                'item_name',
                DB::raw('SUM(CASE WHEN state = 1 THEN 1 ELSE 0 END) as available'),
                DB::raw('SUM(CASE WHEN state = 0 THEN 1 ELSE 0 END) as unavailable'),
                DB::raw('SUM(CASE WHEN state IN (0, 1) THEN 1 ELSE 0 END) as total')
            )
            ->groupBy('item_name')
            ->get();

        if ($categoryItems->count() > 0) {
            $message = 'Search results found.';
            $alertType = 'success';
        } else {
            $message = 'No items found for this category.';
            $alertType = 'warning';
        }
        return view('inventory.items.showdetail', compact('categoryItems', 'message', 'alertType'));
    }
}
