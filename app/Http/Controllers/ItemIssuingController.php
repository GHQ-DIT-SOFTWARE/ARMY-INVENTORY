<?php

namespace App\Http\Controllers;

use App\Models\Electronic_Gadget;
use App\Models\inventoryrecord;
use App\Models\IssueItemOut;
use App\Models\Item;
use App\Models\Personnel;
use App\Models\RetElectronicItem;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    protected function issueQuery()
    {
        return IssueItemOut::query()
            ->with([
                'issuedoutitem.category',
                'issuedoutitem.subcategory',
                'unit',
                'createdBy',
            ]);
    }

    public function GeneralItemView()
    {
        if (! Schema::hasTable('issue_item_outs')) {
            return view('records.GeneralItem.index', [
                'issues' => collect(),
                'summary' => [
                    'totalIssues' => 0,
                    'activeLoans' => 0,
                    'returned' => 0,
                    'unitIssues' => 0,
                ],
            ]);
        }

        $issues = $this->issueQuery()->latest('created_at')->get();

        $summary = [
            'totalIssues' => $issues->count(),
            'activeLoans' => $issues->where('status', 0)->count(),
            'returned' => $issues->where('status', 1)->count(),
            'unitIssues' => $issues->whereNotNull('unit_id')->count(),
        ];

        return view('records.GeneralItem.index', compact('issues', 'summary'));
    }

    public function generalIssuedItems()
    {
        if (! Schema::hasTable('issue_item_outs')) {
            return view('records.GeneralItem.issued', ['issues' => collect()]);
        }

        $issues = $this->issueQuery()
            ->where('status', 0)
            ->latest('created_at')
            ->get();

        return view('records.GeneralItem.issued', compact('issues'));
    }

    public function generalReturnQueue()
    {
        if (! Schema::hasTable('issue_item_outs')) {
            return view('records.GeneralItem.return', ['issues' => collect()]);
        }

        $issues = $this->issueQuery()
            ->where('status', 0)
            ->latest('created_at')
            ->get();

        return view('records.GeneralItem.return', compact('issues'));
    }

    public function generalReturnedItems()
    {
        if (! Schema::hasTable('issue_item_outs')) {
            return view('records.GeneralItem.returned', ['issues' => collect()]);
        }

        $issues = $this->issueQuery()
            ->where('status', 1)
            ->latest('confirmed_issued')
            ->get();

        return view('records.GeneralItem.returned', compact('issues'));
    }
    public function CreateGeneralItem()
    {
        $units = Schema::hasTable('units')
            ? Unit::orderBy('unit_name')->get(['id', 'unit_name'])
            : collect();

        $personnels = collect();
        if (Schema::hasTable('personnels')) {
            $personnelQuery = Personnel::orderBy('svcnumber')
                ->select(['uuid', 'svcnumber', 'surname', 'othernames']);

            if (Schema::hasColumn('personnels', 'unit_id')) {
                $personnelQuery->addSelect('unit_id');
            }

            if (Schema::hasColumn('personnels', 'unit_name')) {
                $personnelQuery->addSelect('unit_name');
            }

            $personnels = $personnelQuery->get();
        }

        $items = Schema::hasTable('items')
            ? Item::with(['category', 'subcategory'])->where('qty', '>', 0)->orderBy('item_name')->get()
            : collect();

        $summary = [
            'availableItems' => $items->count(),
            'totalStock' => $items->sum('qty'),
            'units' => $units->count(),
            'personnels' => $personnels->count(),
        ];

        return view('records.GeneralItem.create', compact('personnels', 'units', 'items', 'summary'));
    }
    public function GeneralItemStore(Request $request)
    {
        if (! Schema::hasTable('items') || ! Schema::hasTable('issue_item_outs')) {
            return redirect()->back()->withErrors([
                'item_id' => 'General control issuing is currently unavailable because the required tables are missing.',
            ]);
        }

        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'issue_to' => ['required', 'in:unit,personnel'],
            'unit_id' => ['nullable', 'required_if:issue_to,unit', 'exists:units,id'],
            'personnel_uuid' => ['nullable', 'required_if:issue_to,personnel', 'exists:personnels,uuid'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $quantity = (int) $validated['quantity'];

        if ($quantity > (int) $item->qty) {
            return redirect()->back()->withErrors([
                'quantity' => "Requested quantity exceeds available stock ({$item->qty}).",
            ])->withInput();
        }

        $issuedToLabel = '';
        $remarks = $validated['notes'] ?? null;
        $unitId = null;

        if ($validated['issue_to'] === 'unit') {
            if (! Schema::hasTable('units')) {
                return redirect()->back()->withErrors([
                    'unit_id' => 'Units table is not available. Please configure units before issuing to a unit.',
                ]);
            }

            $unit = Unit::findOrFail($validated['unit_id']);
            $issuedToLabel = 'Unit: ' . $unit->unit_name;
            $unitId = $unit->id;
        } else {
            if (! Schema::hasTable('personnels')) {
                return redirect()->back()->withErrors([
                    'personnel_uuid' => 'Personnel records are unavailable. Please sync personnel data before issuing to individuals.',
                ]);
            }

            $personnel = Personnel::where('uuid', $validated['personnel_uuid'])->firstOrFail();
            $personnelName = trim(($personnel->surname ?? '') . ' ' . ($personnel->othernames ?? ''));
            $issuedToLabel = 'Personnel: ' . ($personnelName !== '' ? $personnelName : $personnel->svcnumber);
            if (Schema::hasColumn('personnels', 'unit_id') && isset($personnel->unit_id)) {
                $unitId = $personnel->unit_id ?: null;
            } elseif (Schema::hasColumn('personnels', 'unit_name') && ! empty($personnel->unit_name) && Schema::hasTable('units')) {
                $unitRecord = Unit::whereRaw('UPPER(unit_name) = ?', [strtoupper($personnel->unit_name)])->first();
                if ($unitRecord) {
                    $unitId = $unitRecord->id;
                }
            }
            $remarks = trim(($remarks ? $remarks . ' | ' : '') . 'SVC: ' . $personnel->svcnumber);
        }

        DB::transaction(function () use ($item, $quantity, $issuedToLabel, $remarks, $unitId) {
            $item->qty = (int) $item->qty - $quantity;
            $item->save();

            IssueItemOut::create([
                'category_id' => $item->category_id,
                'sub_category' => $item->sub_category,
                'item_id' => $item->id,
                'sizes' => $item->sizes,
                'qty' => $quantity,
                'unit_id' => $unitId,
                'description' => $issuedToLabel,
                'invoice_no' => 'CTRL-' . Str::upper(Str::random(6)),
                'confirm_qty' => $quantity,
                'remarks' => $remarks,
                'status' => 0,
                'date' => now(),
                'created_by' => Auth::id(),
            ]);
        });

        $notification = [
            'message' => 'Item issued successfully.',
            'alert-type' => 'success',
        ];

        return redirect()->route('controls.general-items.issued')->with($notification);
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
        if (! Schema::hasTable('issue_item_outs')) {
            return redirect()->back()->withErrors([
                'status' => 'General control issuing is currently unavailable because the required table is missing.',
            ]);
        }

        $issue = IssueItemOut::findOrFail($id);

        if ((int) $issue->status === 1) {
            return redirect()->back()->with([
                'message' => 'Issue already marked as returned.',
                'alert-type' => 'info',
            ]);
        }

        DB::transaction(function () use ($issue) {
            $issue->status = 1;
            $issue->confirmed_issued = now();
            $issue->save();

            $item = Item::find($issue->item_id);
            if ($item) {
                $item->qty = (int) $item->qty + (int) $issue->qty;
                $item->save();
            }
        });

        return redirect()->back()->with([
            'message' => 'Issue marked as returned successfully.',
            'alert-type' => 'success',
        ]);
    }

    public function GeneralonLoan($id)
    {
        if (! Schema::hasTable('issue_item_outs')) {
            return redirect()->back()->withErrors([
                'status' => 'General control issuing is currently unavailable because the required table is missing.',
            ]);
        }

        $issue = IssueItemOut::findOrFail($id);
        $item = Item::find($issue->item_id);

        if ((int) $issue->status === 1 && $item && (int) $item->qty < (int) $issue->qty) {
            return redirect()->back()->withErrors([
                'quantity' => 'Insufficient stock to place this item back on loan.',
            ]);
        }

        DB::transaction(function () use ($issue, $item) {
            if ((int) $issue->status === 1 && $item) {
                $item->qty = (int) $item->qty - (int) $issue->qty;
                $item->save();
            }

            $issue->status = 0;
            $issue->confirmed_issued = null;
            $issue->save();
        });

        return redirect()->back()->with([
            'message' => 'Issue reopened successfully.',
            'alert-type' => 'success',
        ]);
    }

    public function generalIssueDetails($id)
    {
        if (! Schema::hasTable('issue_item_outs')) {
            abort(404);
        }

        $issue = IssueItemOut::with([
            'issuedoutitem.category',
            'issuedoutitem.subcategory',
            'unit',
            'createdBy',
        ])->findOrFail($id);

        $issuedToType = $issue->unit_id ? 'Unit' : 'Personnel';
        $issuedTo = $issue->unit_id
            ? optional($issue->unit)->unit_name
            : ($issue->description ?? 'Personnel');

        return view('records.GeneralItem.show', [
            'issue' => $issue,
            'issuedToType' => $issuedToType,
            'issuedTo' => $issuedTo,
        ]);
    }

    public function generalReissueForm($id)
    {
        if (! Schema::hasTable('issue_item_outs')) {
            abort(404);
        }

        $issue = IssueItemOut::with([
            'issuedoutitem.category',
            'issuedoutitem.subcategory',
            'unit',
        ])->findOrFail($id);

        if ((int) $issue->status !== 1) {
            return redirect()->back()->withErrors([
                'status' => 'This record is not in a returned state and cannot be re-issued.',
            ]);
        }

        $units = Schema::hasTable('units')
            ? Unit::orderBy('unit_name')->get(['id', 'unit_name'])
            : collect();

        $personnels = collect();
        $defaultPersonnel = null;
        if (Schema::hasTable('personnels')) {
            $personnelQuery = Personnel::orderBy('svcnumber')
                ->select(['uuid', 'svcnumber', 'surname', 'othernames']);

            if (Schema::hasColumn('personnels', 'unit_id')) {
                $personnelQuery->addSelect('unit_id');
            }

            $personnels = $personnelQuery->get();

            if (! empty($issue->remarks) && preg_match('/SVC:\\s*(\\S+)/', $issue->remarks, $matches)) {
                $svc = $matches[1];
                $defaultPersonnel = Personnel::where('svcnumber', $svc)->first();
            }
        }

        $item = $issue->issuedoutitem ?: Item::find($issue->item_id);
        $summary = [
            'availableStock' => optional($item)->qty ?? 0,
            'activeLoans' => IssueItemOut::where('item_id', $issue->item_id)->where('status', 0)->count(),
            'returnedLoans' => IssueItemOut::where('item_id', $issue->item_id)->where('status', 1)->count(),
        ];

        return view('records.GeneralItem.reissue', [
            'issue' => $issue,
            'item' => $item,
            'units' => $units,
            'personnels' => $personnels,
            'summary' => $summary,
            'defaultPersonnel' => $defaultPersonnel,
        ]);
    }

    public function generalReissue(Request $request, $id)
    {
        if (! Schema::hasTable('issue_item_outs')) {
            abort(404);
        }

        $issue = IssueItemOut::with('issuedoutitem')->findOrFail($id);

        if ((int) $issue->status !== 1) {
            return redirect()->back()->withErrors([
                'status' => 'Only returned records can be re-issued.',
            ]);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'issue_to' => ['required', 'in:unit,personnel'],
            'unit_id' => ['nullable', 'required_if:issue_to,unit', 'exists:units,id'],
            'personnel_uuid' => ['nullable', 'required_if:issue_to,personnel', 'exists:personnels,uuid'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = Item::findOrFail($issue->item_id);
        $quantity = (int) $validated['quantity'];

        if ($quantity > (int) $item->qty) {
            return redirect()->back()->withErrors([
                'quantity' => "Requested quantity exceeds available stock ({$item->qty}).",
            ])->withInput();
        }

        $issuedToLabel = '';
        $remarks = $validated['notes'] ?? null;
        $unitId = null;

        if ($validated['issue_to'] === 'unit') {
            if (! Schema::hasTable('units')) {
                return redirect()->back()->withErrors([
                    'unit_id' => 'Units data is unavailable. Please configure units before issuing.',
                ]);
            }

            $unit = Unit::findOrFail($validated['unit_id']);
            $issuedToLabel = 'Unit: ' . $unit->unit_name;
            $unitId = $unit->id;
        } else {
            if (! Schema::hasTable('personnels')) {
                return redirect()->back()->withErrors([
                    'personnel_uuid' => 'Personnel records are unavailable. Please sync personnel data before issuing to individuals.',
                ]);
            }

            $personnel = Personnel::where('uuid', $validated['personnel_uuid'])->firstOrFail();
            $personnelName = trim(($personnel->surname ?? '') . ' ' . ($personnel->othernames ?? ''));
            $issuedToLabel = 'Personnel: ' . ($personnelName !== '' ? $personnelName : $personnel->svcnumber);

            if (Schema::hasColumn('personnels', 'unit_id') && isset($personnel->unit_id)) {
                $unitId = $personnel->unit_id ?: null;
            }

            if (Schema::hasColumn('personnels', 'unit_name') && ! empty($personnel->unit_name) && Schema::hasTable('units')) {
                $unitRecord = Unit::whereRaw('UPPER(unit_name) = ?', [strtoupper($personnel->unit_name)])->first();
                if ($unitRecord) {
                    $unitId = $unitRecord->id;
                }
            }

            $remarks = trim(($remarks ? $remarks . ' | ' : '') . 'SVC: ' . $personnel->svcnumber);
        }

        DB::transaction(function () use ($issue, $item, $quantity, $issuedToLabel, $remarks, $unitId) {
            $item->qty = (int) $item->qty - $quantity;
            $item->save();

            $issue->qty = $quantity;
            $issue->confirm_qty = $quantity;
            $issue->unit_id = $unitId;
            $issue->description = $issuedToLabel;
            $issue->remarks = $remarks;
            $issue->status = 0;
            $issue->date = now();
            $issue->confirmed_issued = null;
            $issue->created_by = Auth::id();

            if (empty($issue->invoice_no)) {
                $issue->invoice_no = 'CTRL-' . Str::upper(Str::random(6));
            }

            $issue->save();
        });

        return redirect()->route('controls.general-items.issued')->with([
            'message' => 'Item re-issued successfully.',
            'alert-type' => 'success',
        ]);
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
