<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ItemWithQuantityController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index()
    {

        return view('item_list_with_qty.index');
    }

    public function add()
    {
        $category = Category::all();
        return view('item_list_with_qty.create', compact('category'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'mou_qty' => 'required|numeric',
            'actual_qty' => 'required|numeric',
        ]);
        $mou_qty = $request->mou_qty;
        $actual_qty = $request->actual_qty;
        $difference = $actual_qty - $mou_qty;
        if ($difference >= 0) {
            $surplus = $difference;
            $deficiency = 0;
        } else {
            $surplus = 0;
            $deficiency = $difference;
        }
        Item::create([
            'sub_category' => $request->sub_category,
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'mou_qty' => $mou_qty,
            'actual_qty' => $actual_qty,
            'surplus' => $surplus,
            'deficiency' => $deficiency,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Item Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-items-quantities')->with($notification);
    }

    public function edit($uuid)
    {

        $category = Category::all();
        $item = Item::where('uuid', $uuid)->first();
        if (!$item) {
            abort(404);
        }
        return view('item_list_with_qty.edit', compact('category', 'item'));
    }

    public function update(Request $request, $uuid)
    {
        if (is_null($this->user) || !$this->user->can('logistic.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }
        $item = Item::where('uuid', $uuid)->first();
        if (!$item) {
            abort(404);
        }
        $request->validate([
            'item_name' => 'required',
            'mou_qty' => 'required|numeric',
            'actual_qty' => 'required|numeric',
        ]);
        $mou_qty = $request->mou_qty;
        $actual_qty = $request->actual_qty;
        $difference = $actual_qty - $mou_qty;
        if ($difference >= 0) {
            $surplus = $difference;
            $deficiency = 0;
        } else {
            $surplus = 0;
            $deficiency = $difference;
        }
        $item->update([
            'sub_category' => $request->sub_category,
            // 'mission_id' => $request->mission_id,
            'category_id' => $request->category_id,
            'item_name' => $request->item_name,
            'mou_qty' => $mou_qty,
            'actual_qty' => $actual_qty,
            'surplus' => $surplus,
            'deficiency' => $deficiency,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
        $notification = [
            'message' => 'Item Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-items-quantities')->with($notification);
    }

    public function delete($uuid)
    {

        $item = Item::where('uuid', $uuid)->first();
        if (!$item) {
            abort(404);
        }
        $item->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
