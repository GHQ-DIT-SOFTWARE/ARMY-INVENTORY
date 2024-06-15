<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class IssueItemOutController extends Controller
{
    public function issueout()
    {
        $category = Category::all();
        $products = Item::orderBy('item_name', 'ASC')->get();
        return view('Issueitemout.issueitemout', compact('products', 'category'));
    }
}
