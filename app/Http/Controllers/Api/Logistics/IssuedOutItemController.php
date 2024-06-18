<?php
declare (strict_types = 1);
namespace App\Http\Controllers\Api\Logistics;

use App\Http\Controllers\Controller;
use App\Models\IssueItemOut;
use Yajra\DataTables\DataTables;

class IssuedOutItemController extends Controller
{
    public function index()
    {
        $items = IssueItemOut::with(['issuedoutitem'])->get();
        return DataTables::of($items)
            ->addColumn('action', function ($items) {
                return '
                    <a class="btn btn-danger btn-sm" href="' . route('delete-item-issued-out', $items->uuid) . '"id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->addColumn('item_name', function ($items) {
                return $items->issuedoutitem ? $items->issuedoutitem->item_name : '';
            })
            ->editColumn('date', function ($items) {
                return $items->date ? date('d M, Y', strtotime($items->date)) : '';
            })
            ->editColumn('invoice_no', function ($item) {
                return '#' . $item->invoice_no;
            })
            ->rawColumns(['action', 'date', 'item_name', 'invoice_no'])
            ->make(true);
    }
}
