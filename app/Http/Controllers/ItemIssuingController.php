<?php

namespace App\Http\Controllers;

use App\Models\Electronic_Gadget;
use App\Models\GeneralItemIssuing;
use App\Models\inventoryrecord;
use App\Models\NonElectronicItem;
use App\Models\RetElectronicItem;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class ItemIssuingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function RouteIssue()
    {
        return View('records.show');
    }
    public function ReceiveIssue()
    {
        return View('records.ReceieveItem.show');
    }
    public function index()
    {
        $electronicissue = inventoryrecord::get();
        return view('records.index', compact('electronicissue'));
    }
    public function create()
    {
        $allusers = User::get();
        $eletronicitem = DB::table('electronic__gadgets')->join('categories', 'electronic__gadgets.category_name',
            '=', 'categories.id')->get();
        return view('records.create', compact('allusers', 'eletronicitem'));
    }
    public function StoreElectronic(Request $request)
    {
        $existingRecord = inventoryrecord::where('serial_no', $request->serial_no)
            ->whereIn('state', [0])
            ->first();
        if ($existingRecord) {
            $notification = array(
                'message' => 'Item with Serial No. ' . $request->serial_no . ' has already out.',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        } else {
            DB::transaction(function () use ($request) {
                $data = new inventoryrecord();
                $data->svcnumber = $request->svcnumber;
                $data->surname = $request->surname;
                $data->gender = $request->gender;
                $data->mobile = $request->mobile;
                $data->rank_name = $request->rank_name;
                $data->othernames = $request->othernames;
                $data->serial_no = $request->serial_no;
                $data->product_name = $request->product_name;
                $data->item_location = $request->item_location;
                $data->category_name = $request->category_name;
                $data->issued_date = $request->issued_date;
                $data->state = $request->state;
                $data->created_by = Auth::user()->id;
                $data->save();
                $electronicGadget = Electronic_Gadget::where('serial_no', $request->serial_no)->first();
                if ($electronicGadget) {
                    $electronicGadget->state = 0; // set state to 1 for loan
                    $electronicGadget->save();
                }
            });
            $notification = array(
                'message' => 'Record inserted successfully. Item with Serial No. ' . $request->serial_no . ' is  out.',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.electronic.view')->with($notification);
        }
    }
    public function GeneralItemView()
    {
        $generalview = GeneralItemIssuing::get();
        return view('records.GeneralItem.index', compact('generalview'));
    }
    public function CreateGeneralItem()
    {
        $personnels = DB::table('personnels')
            ->join('ranks', 'personnels.rank_name', '=', 'ranks.id')
            ->get();
        $generalitem = DB::table('non_electronic_items')->join('categories', 'non_electronic_items.category_name',
            '=', 'categories.id')->get();
        return view('records.GeneralItem.create', compact('personnels', 'generalitem'));
    }
    public function GeneralItemStore(Request $request)
    {
        $existingRecord = GeneralItemIssuing::where('body_no', $request->body_no)
            ->whereIn('status', [2])
            ->first();
        if ($existingRecord) {
            $notification = array(
                'message' => 'Item with Body No.' . $request->body_no . ' has already been loaned out.',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        } else {
            DB::transaction(function () use ($request) {
                $data = new GeneralItemIssuing();
                $data->svcnumber = $request->svcnumber;
                $data->surname = $request->surname;
                $data->gender = $request->gender;
                $data->mobile = $request->mobile;
                $data->rank_name = $request->rank_name;
                $data->othernames = $request->othernames;
                $data->email = $request->email;
                $data->body_no = $request->body_no;
                $data->product_name = $request->product_name;
                $data->item_location = $request->item_location;
                $data->category_name = $request->category_name;
                $data->status = $request->status;
                $data->created_by = Auth::user()->id;
                $data->save();
                $GeneralItem = NonElectronicItem::where('body_no', $request->body_no)->first();
                if ($GeneralItem) {
                    $GeneralItem->state = 0;
                    $GeneralItem->save();
                }
            });
            $notification = array(
                'message' => 'Record inserted successfully. Item with Body No. ' . $request->body_no . ' has been  out.',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.general.view')->with($notification);
        }
    }
    public function Delete($id)
    {
        recordcourse::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Record Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    public function ElecreturnBtn($id)
    {
        $electronicissue = inventoryrecord::findOrFail($id);
        if ($electronicissue) {
            $electronicissue->state = 0;
            $electronicissue->save();
            $notification = array(
                'message' => 'Item Loaned Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.electronic.view')->with($notification);
        }
    }
    public function ElecLoanBtn($id)
    {
        $electronicissue = inventoryrecord::findOrFail($id);
        if ($electronicissue) {
            $electronicissue->state = 1;
            $electronicissue->save();
            $notification = array(
                'message' => 'Item Retuned Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.electronic.view')->with($notification);
        }
    }
    public function GeneralReturn($id)
    {
        $generalview = GeneralItemIssuing::findOrFail($id);
        if ($generalview) {
            $generalview->status = 0;
            $generalview->save();
            $notification = array(
                'message' => 'Item Loaned Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.general.view')->with($notification);
        }
    }
    public function GeneralonLoan($id)
    {
        $generalview = GeneralItemIssuing::findOrFail($id);
        if ($generalview) {
            $generalview->status = 1;
            $generalview->save();
            $notification = array(
                'message' => 'Item Retuned Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('item.issue.general.view')->with($notification);
        }
    }
    public function RecieveEletronicItem()
    {
        $receiveitem = RetElectronicItem::get();
        return view('records.ReceieveItem.Electronic.index', compact('receiveitem'));
    }
    public function RecieveEletronicCreate()
    {
        $eletronicitem = DB::table('electronic__gadgets')->join('categories', 'electronic__gadgets.category_name',
            '=', 'categories.id')->get();
        return view('records.ReceieveItem.Electronic.create', compact('eletronicitem'));
    }
    public function RecieveEletronicStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $data = new RetElectronicItem();
            $data->svcnumber = $request->svcnumber;
            $data->surname = $request->surname;
            $data->gender = $request->gender;
            $data->mobile = $request->mobile;
            $data->rank_name = $request->rank_name;
            $data->othernames = $request->othernames;
            $data->serial_no = $request->serial_no;
            $data->product_name = $request->product_name;
            $data->item_location = $request->item_location;
            $data->category_name = $request->category_name;
            $data->receive_date = $request->receive_date;
            $data->state = $request->state;
            $data->created_by = Auth::user()->id;
            $data->save();
            $electronicGadgetreceive = Electronic_Gadget::where('serial_no', $request->serial_no)->first();
            if ($electronicGadgetreceive) {
                $electronicGadgetreceive->state = 1; // set state to 1 for loan
                $electronicGadgetreceive->save();
            }
        });
        $notification = array(
            'message' => 'Item Retuned Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('item.receive.electronic.view')->with($notification);
    }
}
