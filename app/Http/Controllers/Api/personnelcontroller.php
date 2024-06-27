<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class personnelcontroller extends Controller
{
    public function index(Request $request)
    {
        $query = Personnel::query();
        $result = DataTables::of($query)
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary btn-sm" href="' . route('personal-edit', $record->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('personal-delete', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
        return $result;
    }
}
