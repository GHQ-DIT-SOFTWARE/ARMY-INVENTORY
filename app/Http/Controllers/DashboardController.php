<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\inventoryrecord;
use App\Models\RetElectronicItem;
use App\Models\Role;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function View()
    {
        $total_roles = count(Role::select('id')->get());
        $total_users = count(User::select('id')->get());

        $total_category = count(Category::select('id')->get());

        return view('homedash', compact('total_roles', 'total_users',
            'total_category'));
    }

    public function Historytable()
    {
        $received_item = RetElectronicItem::get();
        $Loaned_Item = inventoryrecord::get();
        return view('dashboard', compact('received_item', 'Loaned_Item'));
    }
}
