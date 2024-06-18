<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Restock;
use Yajra\DataTables\DataTables;

class RestockItemController extends Controller
{
    public function index()
    {
        $items = Restock::with(['category', 'subcategory', 'supplier', 'stocks'])->get();
        return DataTables::of($items)
            ->addColumn('action', function ($items) {
                return '
                    <a class="btn btn-danger btn-sm" href="' . route('deletepurchase', $items->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('category_name', function ($items) {
                return $items->category ? $items->category->category_name : '';
            })
            ->addColumn('sub_name', function ($items) {
                return $items->subcategory ? $items->subcategory->sub_name : '';
            })
            ->addColumn('company_name', function ($items) {
                return $items->supplier ? $items->supplier->company_name : '';
            })
            ->addColumn('item_name', function ($items) {
                return $items->stocks ? $items->stocks->item_name : '';
            })
            ->editColumn('restock_date', function ($items) {
                return $items->restock_date ? date('d M, Y', strtotime($items->restock_date)) : '';
            })
            ->rawColumns(['action', 'restock_date', 'item_name', 'category_name', 'sub_name', 'company_name'])
            ->make(true);
    }
}
