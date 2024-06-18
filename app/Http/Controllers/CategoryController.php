<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function View()
    {
        $category = Category::latest()->get();

        return view('category.index', compact('category'));
    }

    public function AddCate()
    {
        return view('category.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', Rule::unique('categories')],
        ]);
        Category::create([
            'category_name' => $request->category_name,
        ]);
        $notification = [
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-index')->with($notification);
    }

    public function Edit($uuid)
    {
        $category = Category::where('uuid', $uuid)->first();
        if (!$category) {
            abort(404);
        }

        return view('category.edit', compact('category'));
    }

    public function Update(Request $request)
    {
        $category_id = $request->uuid;
        $category = Category::where('uuid', $category_id)->first();
        if (!$category) {
            abort(404);
        }
        $category->update([
            'category_name' => $request->category_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = [
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('view-index')->with($notification);
    }

    public function Delete($uuid)
    {
        $category = Category::where('uuid', $uuid)->first();
        if (!$category) {
            abort(404);
        }
        $category->delete();
        $notification = [
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
