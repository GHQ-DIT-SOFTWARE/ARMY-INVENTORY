<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Electronic_Gadget;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
   
    public function View()
    {
        $categoris = Category::orderBy('category_name', 'desc')->get();
        return view('Category.index', compact('categoris'));
    }

    public function AddCate()
    {
        return view('Category.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'category_name' => ['required', Rule::unique('categories')],
        ]);
        Category::insert([
            'category_name' => $request->category_name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('viewindex')->with($notification);
    }

    public function Edit($id)
    {

        $category = Category::findOrFail($id);
        return view('Category.edit', compact('category'));
    }
    public function Update(Request $request)
    {
        $category_id = $request->id;
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);
        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('viewindex')->with($notification);
    }

    public function Delete($id)
    {
        Category::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }


}
