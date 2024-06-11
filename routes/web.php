<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemIssuingController;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\personnelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\rankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/', function () {
//     return view('auth.verify-email');})->middleware(['auth'])->name('verification.notice');
// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.index');
//     })->name('dashboard');
// });
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    // ... your other routes

    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::post('login', [PagesController::class, 'Log_in'])->name('login.dashboard');
Route::get('logout', [PagesController::class, 'Logout'])->name('logout');
Route::post('passwaord/reset', [PagesController::class, 'Resetpassword'])->name('password.update.reset');
//approving status on General
Route::get('/generalinactive{id}', [PagesController::class, 'Inactive'])->name('user.inactive');
Route::get('/generalactive{id}', [PagesController::class, 'Active'])->name('user.active');

Route::get('/login_activities', [LogactivityController::class, 'login_and_logout_activities'])->name('login_and_logout');
Route::prefix('AuditTrail')->group(function () {
    Route::get('/audittrail', [AuditController::class, 'ViewAudit'])->name('audit.trail');
});
Route::group(['prefix' => 'admin'], function () {
    Route::resource('roles', RoleController::class, ['names' => 'roles']);
    Route::resource('users', UserController::class, ['names' => 'users']);
});

Route::prefix('Profile')->group(function () {
    Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profileview');
    Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
    Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
    Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
});
Route::prefix('superadmindashboard')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'View'])->name('home.dash');
    Route::get('/history', [DashboardController::class, 'Historytable'])->name('history.dash');
});
Route::prefix('Category')->group(function () {
    Route::get('/view', [CategoryController::class, 'View'])->name('viewindex');
    Route::get('/add', [CategoryController::class, 'AddCate'])->name('viewcreate');
    Route::post('/store', [CategoryController::class, 'Store'])->name('storecat');
    Route::get('/edit{id}', [CategoryController::class, 'Edit'])->name('catedit');
    Route::post('/update', [CategoryController::class, 'Update'])->name('upcate');
    Route::get('/delete{id}', [CategoryController::class, 'Delete'])->name('catdelete');

});
Route::prefix('Supplier')->group(function () {
    Route::get('/view', [SupplierController::class, 'Index'])->name('viewsupp');
    Route::get('/add', [SupplierController::class, 'create'])->name('supadd');
    Route::post('/store', [SupplierController::class, 'store'])->name('supstore');
    Route::get('/edit{id}', [SupplierController::class, 'Edit'])->name('supedit');
    Route::post('/update', [SupplierController::class, 'update'])->name('supupa');
    Route::get('/delete{id}', [SupplierController::class, 'delete'])->name('supdel');
});
Route::prefix('Items')->group(function () {
    Route::get('/viewroute', [ProductController::class, 'Routine'])->name('route.items');
    Route::get('/view', [ProductController::class, 'View'])->name('viewpro');
    Route::get('/add', [ProductController::class, 'Add'])->name('addpro');
    Route::post('/store', [ProductController::class, 'Store'])->name('storepro');
    Route::get('/edit{id}', [ProductController::class, 'Edit'])->name('editpro');
    Route::post('/update', [ProductController::class, 'Update'])->name('updatepro');
    Route::get('/delete{id}', [ProductController::class, 'Delete'])->name('deletepro');

    Route::get('/viewnon', [ProductController::class, 'Indexnon'])->name('view.nonpro');
    Route::get('/addnon', [ProductController::class, 'Createnon'])->name('add.nonpro');
    Route::post('/storenon', [ProductController::class, 'Storenon'])->name('store.nonpro');
    Route::get('/nonedit{id}', [ProductController::class, 'Editnon'])->name('edit.nonpro');
    Route::post('/nonupdate', [ProductController::class, 'Updatenon'])->name('update.nonpro');
    Route::get('/nondelete{id}', [ProductController::class, 'Deletenon'])->name('delete.nonpro');
    Route::get('/viewstatusnon', [ProductController::class, 'sernon'])->name('view.nonstaone');
    Route::get('/viewstatusnonelec', [ProductController::class, 'sernonelec'])->name('view.nonstazero');
    Route::get('/viewstatuselectronics', [ProductController::class, 'serelec'])->name('view.elec.one');
    Route::get('/viewstatusnonelectronics', [ProductController::class, 'sernonelectronic'])->name('view.elec.stazero');
    //Status
    Route::get('/approving{id}', [ProductController::class, 'Approve'])->name('item.approve');
    Route::get('/electronicser{id}', [ProductController::class, 'Rescheduled'])->name('item.reschudel');
    Route::get('/ser{id}', [ProductController::class, 'Ser'])->name('item.ser');
    Route::get('/unser{id}', [ProductController::class, 'Unser'])->name('item.unserv');
    //End Status
    Route::get('/totalviewqty', [ProductController::class, 'eletronicallqty']);
    Route::get('/totalelectronicitem', [ProductController::class, 'alleachqt'])->name('total.each.eletronic.item');
    Route::get('/totalgeneralitems', [ProductController::class, 'alleachqtgeneralitem'])->name('total.each.general.item');
    Route::get('/totalserunserv', [ProductController::class, 'serveandunser'])->name('total.serveandunser');
    Route::get('/totalgeneralserunserv', [ProductController::class, 'serveandunsernon'])->name('total.general.serveandunser');
    //Availbility
    Route::get('/eletronicavailability{id}', [ProductController::class, 'Electronicavailability'])->name('item.eletronic.availability');
    Route::get('/eletronicunavailability{id}', [ProductController::class, 'ElectronicUnavailability'])->name('item.eletronic.unavailability');
    Route::get('/generalavailability{id}', [ProductController::class, 'Generalavailability'])->name('item.general.availability');
    Route::get('/generalunavailability{id}', [ProductController::class, 'GeneralUnavailability'])->name('item.general.unavailability');
    //End Availability
    Route::get('/category/{id}/products', [ProductController::class, 'productsByCategory'])->name('category.products');
});
Route::prefix('ranks')->group(function () {
    Route::get('/view', [rankcontroller::class, 'View'])->name('viewrank');
    Route::get('/add', [rankcontroller::class, 'RankAdd'])->name('rankadd');
    Route::post('/store', [rankcontroller::class, 'Store'])->name('rankstore');
    Route::get('/edit{id}', [rankcontroller::class, 'Edit'])->name('rankedit');
    Route::post('/update{id}', [rankcontroller::class, 'Update'])->name('rankupdate');
    Route::get('/delete{id}', [rankcontroller::class, 'Delete'])->name('rankdelete');
});
Route::prefix('Personnel_details')->group(function () {
    Route::get('/view', [personnelController::class, 'index'])->name('perview');
    Route::get('/add', [personnelController::class, 'create'])->name('percreate');
    Route::post('/store', [personnelController::class, 'store'])->name('perstore');
    Route::get('/edit{id}', [personnelController::class, 'edit'])->name('peredit');
    Route::post('/update', [personnelController::class, 'update'])->name('perupdate');
    Route::get('/delete{id}', [personnelController::class, 'delete'])->name('perdelete');
});

Route::prefix('Items_Issuing_out')->group(function () {
    Route::get('/routeview', [ItemIssuingController::class, 'RouteIssue'])->name('item.issue.routing.view');
    Route::get('/routereceive', [ItemIssuingController::class, 'ReceiveIssue'])->name('item.issue.receiving.view');
    Route::get('/view', [ItemIssuingController::class, 'index'])->name('item.issue.electronic.view');
    Route::get('/add', [ItemIssuingController::class, 'create'])->name('item.issue.electronic.create');
    Route::post('/store', [ItemIssuingController::class, 'StoreElectronic'])->name('item.issue.electronic.store');
    //Issuing General Item Out
    Route::get('/generalviewing', [ItemIssuingController::class, 'GeneralItemView'])->name('item.issue.general.view');
    Route::get('/generaliussing', [ItemIssuingController::class, 'CreateGeneralItem'])->name('item.issue.general.create');
    Route::post('/generaliussing', [ItemIssuingController::class, 'GeneralItemStore'])->name('item.issue.general.store');
    Route::get('/delete{id}', [ItemIssuingController::class, 'delete'])->name('item.issue.electronic.delete');
    //approving status on Electrnoic
    Route::get('/eletronicretun{id}', [ItemIssuingController::class, 'ElecreturnBtn'])->name('item.eletronic.returned');
    Route::get('/eletronicloaned{id}', [ItemIssuingController::class, 'ElecLoanBtn'])->name('item.eletronic.loaned');
    //approving status on General
    Route::get('/generalretuned{id}', [ItemIssuingController::class, 'GeneralReturn'])->name('item.general.returned');
    Route::get('/generalloan{id}', [ItemIssuingController::class, 'GeneralonLoan'])->name('item.general.loaned');
    //Receiving Items Electronic
    Route::get('/itemreceiveview', [ItemIssuingController::class, 'RecieveEletronicItem'])->name('item.receive.electronic.view');
    Route::get('/itemreceivecreate', [ItemIssuingController::class, 'RecieveEletronicCreate'])->name('item.receive.electronic.create');
    Route::post('/itemreceivestore', [ItemIssuingController::class, 'RecieveEletronicStore'])->name('item.receive.electronic.store');
});
