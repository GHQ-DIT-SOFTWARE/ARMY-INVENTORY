<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Electronic_Gadget;
use App\Models\inventoryrecord;
use App\Models\NonElectronicItem;
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
        $total_nonelectronic = count(NonElectronicItem::select('id')->get());
        // $total_electronic = count(Electronic_Gadget::select('id')->get());
        $total_sevnon = count(NonElectronicItem::select('id')->where('status', '1')->get());
        $total_unsernon = count(NonElectronicItem::select('id')->where('status', '0')->get());
        // $total_ser = count(Electronic_Gadget::select('id')->where('status', '1')->get());
        // $total_unser = count(Electronic_Gadget::select('id')->where('status', '0')->get());
        $total_item_returned = count(RetElectronicItem::select('id')->where('state', '1')->get());
        $total_item_loaned = count(inventoryrecord::select('id')->where('state', '0')->get());
        $total_category = count(Category::select('id')->get());

        return view('homedash', compact('total_roles', 'total_users', 'total_nonelectronic',
           'total_category', 'total_sevnon', 'total_unsernon',
             'total_item_returned', 'total_item_loaned'));
    }

    public function Historytable()
    {
        $received_item = RetElectronicItem::get();
        $Loaned_Item = inventoryrecord::get();
        return view('dashboard', compact('received_item', 'Loaned_Item'));
    }
}
