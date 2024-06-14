<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = SubCategory::with(['item_category']);
        $result = DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary btn-sm" href="' . route('edit-subcategory', $record->uuid) . '"><i class="feather icon-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href="' . route('delete-subcategory', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
        return $result;
    }

    public function View()
    {
        return view('subcategory.index');
    }

    public function Add()
    {
        $sub_category = Category::all();
        return view('subcategory.create', compact('sub_category'));
    }

    public function Store(Request $request)
    {
        $request->validate([
            'sub_name' => ['required', Rule::unique('sub_categories')],
            'category_id' => 'required',
        ]);
        SubCategory::create([
            'sub_name' => $request->sub_name,
            'category_id' => $request->category_id,
            // 'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-subcategory')->with($notification);
    }

    public function Edit($uuid)
    {
        $subcategory = SubCategory::where('uuid', $uuid)->first();
        if (!$subcategory) {
            abort(404);
        }
        $category = Category::all();
        return view('subcategory.edit', compact('subcategory', 'category'));
    }

    public function Update(Request $request, $uuid)
    {
        $subcategory = SubCategory::where('uuid', $uuid)->first();
        if (!$subcategory) {
            abort(404);
        }
        $subcategory->sub_name = $request->sub_name;
        $subcategory->category_id = $request->category_id;
        // $subcategory->updated_by = Auth::user()->id;
        $subcategory->save();
        $notification = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('view-subcategory')->with($notification);
    }

    public function Delete($uuid)
    {
        $subcategory = SubCategory::where('uuid', $uuid)->first();
        if (!$subcategory) {
            abort(404);
        }
        $subcategory->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}
