<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Yajra\DataTables\DataTables;

class ItemsWithQuantityController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                return '<a class="btn btn-primary btn-sm" href="' . route('edit-items-quantities', $item->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('delete-items-quantities', $item->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('category_name', function ($item) {
                return $item->category ? $item->category->category_name : '';
            })
            ->addColumn('sub_name', function ($item) {
                return $item->subcategory ? $item->subcategory->sub_name : '';
            })
            ->rawColumns(['action', 'category_name', 'sub_name'])
            ->make(true);
    }
}
