<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api\Logistics;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LogisticsController extends Controller
{
    public function filter_item(Request $request)
    {
        $items = Item::with(['category', 'items', 'subcategory', 'item_mission']);
        if ($request->filled('type_own')) {
            $items->where('type_own', $request->type_own);
        }
        if ($request->filled('state')) {
            $items->where('status', $request->state);
        }
        if ($request->filled('category_id')) {
            $items->where('category_id', $request->category_id);
        }
        if ($request->filled('mission_id')) {
            $items->where('mission_id', $request->mission_id);
        }
        if ($request->filled('item_name')) {
            $items->where('item_name', $request->item_name);
        }
        $items = $items->get();
        return DataTables::of($items)
            ->addColumn('category_name', function ($item) {
                return $item->category ? $item->category->category_name : '';
            })
            ->addColumn('item_name', function ($item) {
                return $item->items ? $item->items->item_name : '';
            })
            ->addColumn('sub_name', function ($item) {
                return $item->subcategory ? $item->subcategory->sub_name : '';
            })
            ->addColumn('mission_name', function ($item) {
                return $item->item_mission ? $item->item_mission->mission_name : '';
            })
            ->editColumn('status', function ($item) {
                switch ($item->state) {
                    case '1':
                        return '<span class="badge badge-success mr-1">SERVICEABLE</span>';
                    case '0':
                        return '<span class="badge badge-danger mr-1">UNSERVICEABLE</span>';
                    default:
                        return '';
                }
            })
            ->editColumn('state', function ($item) {
                switch ($item->status) {
                    case '1':
                        return '<span class="badge badge-success mr-1">AVAILABLE</span>';
                    case '0':
                        return '<span class="badge badge-danger mr-1">UNAVAILABLE</span>';
                    default:
                        return '';
                }
            })
            ->rawColumns(['status', 'state', 'category_name', 'item_name', 'sub_name', 'mission_name'])
            ->make(true);
    }

    public function index()
    {
        $items = Item::with(['category', 'subcategory'])->get();
        return DataTables::of($items)
            ->addColumn('action', function ($items) {
                return '
            <a class="btn btn-primary btn-sm" href="' . route('edit-item', $items->uuid) . '"><i class="feather icon-edit"></i></a>
                    <a class="btn btn-danger btn-sm" href="' . route('delete-item', $items->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('category_name', function ($items) {
                return $items->category ? $items->category->category_name : '';
            })
            ->addColumn('sub_name', function ($items) {
                return $items->subcategory ? $items->subcategory->sub_name : '';
            })

            ->editColumn('added_date', function ($items) {
                return $items->added_date ? date('d M, Y', strtotime($items->added_date)) : '';
            })

            ->rawColumns(['action', 'added_date', 'item_name', 'category_name', 'sub_name'])
            ->make(true);
    }

    public function serviceable_items()
    {
        $items = Item::with('category')->where('status', 1)->get();
        return DataTables::of($items)
            ->addColumn('action', function ($items) {
                return '<a class="btn btn-info btn-sm" href="' . route('items-total') . '"><i class="fa fa-eye"></i></a>
                <a class="btn btn-primary btn-sm" href="' . route('edit-item', $items->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('delete-item', $items->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('item_name', function ($items) {
                return $items->items ? $items->items->item_name : '';
            })
            ->addColumn('category_name', function ($items) {
                return $items->category ? $items->category->category_name : '';
            })
            ->addColumn('sub_name', function ($items) {
                return $items->subcategory ? $items->subcategory->sub_name : '';
            })
            ->editColumn('state', function ($items) {
                return '<span class="badge badge-success mr-1">AVAILABLE</span>';
            })
            ->editColumn('status', function ($items) {
                return '<span class="badge badge-success mr-1">SERVICEABLE</span>';
            })
            ->editColumn('added_date', function ($items) {
                return $items->added_date ? date('d M, Y', strtotime($items->added_date)) : '';
            })
            ->editColumn('un_shelf_life', function ($items) {
                return $items->un_shelf_life ? date('d M, Y', strtotime($items->un_shelf_life)) : '';
            })
            ->editColumn('item_value', function ($items) {
                return '$' . $items->item_value;
            })
            ->rawColumns(['action', 'status', 'un_shelf_life', 'added_date', 'category_name', 'item_value', 'item_name', 'sub_name'])
            ->make(true);
    }

    public function unserviceable_items()
    {
        $items = Item::with('category')->where('status', 0)->get();
        return DataTables::of($items)
            ->addColumn('action', function ($items) {
                return '<a class="btn btn-info btn-sm" href="' . route('items-total') . '"><i class="fa fa-eye"></i></a>
                <a class="btn btn-primary btn-sm" href="' . route('edit-item', $items->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('delete-item', $items->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('item_name', function ($items) {
                return $items->items ? $items->items->item_name : '';
            })
            ->addColumn('category_name', function ($items) {
                return $items->category ? $items->category->category_name : '';
            })
            ->addColumn('sub_name', function ($items) {
                return $items->subcategory ? $items->subcategory->sub_name : '';
            })
            ->editColumn('state', function ($items) {
                return '<span class="badge badge-success mr-1">AVAILABLE</span>';
            })
            ->editColumn('status', function ($items) {
                return '<span class="badge badge-success mr-1">SERVICEABLE</span>';
            })
            ->editColumn('added_date', function ($items) {
                return $items->added_date ? date('d M, Y', strtotime($items->added_date)) : '';
            })
            ->editColumn('un_shelf_life', function ($items) {
                return $items->un_shelf_life ? date('d M, Y', strtotime($items->un_shelf_life)) : '';
            })
            ->editColumn('item_value', function ($items) {
                return '$' . $items->item_value;
            })
            ->rawColumns(['action', 'status', 'un_shelf_life', 'added_date', 'category_name', 'item_value', 'item_name', 'sub_name'])
            ->make(true);
    }
}
