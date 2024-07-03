<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

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
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category' => 'required',
            'qty' => 'required|integer',
            'sizes' => 'nullable',
            'item_image' => 'nullable|image',
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

        if ($request->file('item_image')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('item_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('item_image'));
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
            'item_image' => $save_url,
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
        $items = Item::where('uuid', $uuid)->first();
        if (!$items) {
            abort(404);
        }
        return view('items.edit', compact('items', 'category'));
    }

    public function Update(Request $request, $uuid)
    {
        $request->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category' => 'required',
            'qty' => 'required|integer',
            'sizes' => 'required',
            'item_image' => 'nullable|image',
        ]);

        $items = Item::where('uuid', $uuid)->first();
        if (!$items) {
            abort(404);
        }

        if ($request->file('item_image')) {
            // Delete old image if it exists
            if (!empty($items->item_image) && file_exists(public_path($items->item_image))) {
                unlink(public_path($item->item_image));
            }

            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $request->file('item_image')->getClientOriginalExtension();
            $img = $manager->read($request->file('item_image'));
            $img = $img->resize(200, 200);
            $img->save(public_path('uploadimage/Item_images/' . $name_gen));
            $save_url = 'uploadimage/Item_images/' . $name_gen;
        } else {
            $save_url = $items->item_image;
        }
        $items->update([
            'sub_category' => $request->sub_category,
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'qty' => $request->qty,
            'sizes' => $request->sizes,
            'added_date' => Carbon::now(),
            'remarks' => $request->remarks,
            'item_image' => $save_url,
            'updated_by' => Auth::user()->id,
        ]);

        $notification = [
            'message' => 'Item Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-item')->with($notification);
    }

    public function Delete($uuid)
    {
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

    public function getSubCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)->pluck('sub_name', 'id');
        return response()->json($subCategories);
    }

    public function getItems($subCategoryId)
    {
        $items = Item::where('sub_category', $subCategoryId)->pluck('item_name', 'id');
        return response()->json($items);
    }

    // public function getSizes($itemId)
    // {
    //     $item = Item::findOrFail($itemId);
    //     // Assuming 'size' is a field in your Item model containing the size as a string
    //     $sizeOptions = [$item->sizes];
    //     // Return as JSON response
    //     return response()->json($sizeOptions);
    // }
    // public function getQuantity($sizeId)
    // {
    //     // Example: Fetch quantity from the Item model based on the selected size ID
    //     $item = Item::where('sizes', $sizeId)->first();
    //     $quantity = $item ? $item->qty : 0;
    //     return response()->json(['qty' => $quantity]);
    // }

    public function getSizes($itemId)
    {
        $item = Item::findOrFail($itemId);
        $sizeOptions = $item->sizes ? explode(',', $item->sizes) : [];
        return response()->json($sizeOptions);
    }

    public function getQuantity($sizeId)
    {
        // Check if sizeId corresponds to a size or an itemId
        $item = Item::where('sizes', 'LIKE', '%' . $sizeId . '%')->orWhere('id', $sizeId)->first();
        $quantity = $item ? $item->qty : 0;
        return response()->json(['qty' => $quantity]);
    }

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
