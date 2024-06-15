<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\SubCategory;

class DefaultInventoryController extends Controller
{
    public function fetchSubCategory($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    public function fetchCategoryAndSubcategory($itemId)
    {
        // Fetch the item with its related category and subcategory
        $item = Items::with('category', 'subcategory')->find($itemId);
        // Check if the item exists
        if ($item) {
            // Return the category and subcategory data as arrays
            return response()->json([
                'category' => [
                    $item->category->id => [
                        'category_name' => $item->category->category_name,
                    ],
                ],
                'subcategories' => [
                    $item->subcategory->id => [
                        'sub_name' => $item->subcategory->sub_name,
                    ],
                ],
            ]);
        } else {
            // Return empty data if item not found
            return response()->json([
                'category' => [],
                'subcategories' => [],
            ]);
        }
    }

}
