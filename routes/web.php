<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DefaultInventoryController;
use App\Http\Controllers\ItemIssuingController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ItemWithQuantityController;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\personnelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\rankController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

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

Route::prefix('inventory')->group(function () {

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'View'])->name('view-index');
        Route::get('/add', [CategoryController::class, 'AddCate'])->name('create');
        Route::post('/store', [CategoryController::class, 'Store'])->name('store-category');
        Route::get('/edit/{uuid}', [CategoryController::class, 'Edit'])->name('edit-category');
        Route::post('/update', [CategoryController::class, 'Update'])->name('update-category');
        Route::get('/{uuid}', [CategoryController::class, 'Delete'])->name('delete-category');
    });
    Route::prefix('sub-category')->group(function () {
        Route::get('/', [SubCategoryController::class, 'View'])->name('view-subcategory');
        Route::get('/mech', [SubCategoryController::class, 'Add'])->name('mech-subcategory');
        Route::post('/store', [SubCategoryController::class, 'Store'])->name('store-subcategory');
        Route::get('/edit/{uuid}', [SubCategoryController::class, 'Edit'])->name('edit-subcategory');
        Route::post('/update{uuid}', [SubCategoryController::class, 'Update'])->name('update-subcategory');
        Route::get('/delete{uuid}', [SubCategoryController::class, 'Delete'])->name('delete-subcategory');
        Route::post('/view-sub-caregory', [SubCategoryController::class, 'index'])->name('view-sub-caregory');
    });

    Route::prefix('Supplier')->group(function () {
        Route::get('/view', [SupplierController::class, 'Index'])->name('viewsupp');
        Route::get('/add', [SupplierController::class, 'create'])->name('supadd');
        Route::post('/store', [SupplierController::class, 'store'])->name('supstore');
        Route::get('/edit{uuid}', [SupplierController::class, 'Edit'])->name('supedit');
        Route::post('/update', [SupplierController::class, 'update'])->name('supupa');
        Route::get('/delete{uuid}', [SupplierController::class, 'delete'])->name('supdel');
    });
    Route::prefix('item')->group(function () {
        Route::prefix('sub-category')->group(function () {
            Route::get('/get-subcategory/{categoryId}', [DefaultInventoryController::class, 'fetchSubCategory'])->name('get-subcategory');
            Route::get('/fetch-category-and-subcategory/{itemId}', [DefaultInventoryController::class, 'fetchCategoryAndSubcategory'])
                ->name('fetch-category-and-subcategory');
        });
        Route::get('/', [ItemsController::class, 'View'])->name('view-item');
        Route::get('/item-manager', [ItemsController::class, 'manage_item'])->name('manage_item');
        Route::get('/add', [ItemsController::class, 'Add'])->name('add-item');
        Route::post('/store', [ItemsController::class, 'Store'])->name('store-item');
        Route::get('/edit/{uuid}', [ItemsController::class, 'Edit'])->name('edit-item');
        Route::post('/update', [ItemsController::class, 'Update'])->name('update-item');
        Route::get('/delete/{uuid}', [ItemsController::class, 'Delete'])->name('delete-item');
        //Status
        Route::get('/approving{id}', [ItemsController::class, 'Approve'])->name('item.approve');
        Route::get('/electronicser{id}', [ItemsController::class, 'Rescheduled'])->name('item.reschudel');
        Route::get('/serviceable-items', [ItemsController::class, 'Serviceable'])->name('serviceable-item');
        Route::get('/un-serviceable-items', [ItemsController::class, 'Un_Serviceable'])->name('un-serviceable-item');
        Route::get('/un-serviceable{id}', [ItemsController::class, 'Unser'])->name('item.unserv');
        //End Status
        Route::get('/totalviewqty', [ItemsController::class, 'eletronicallqty']);
        Route::get('/item-total', [ItemsController::class, 'alleachqt'])->name('items-total');
        Route::get('/totalserunserv', [ItemsController::class, 'serveandunser'])->name('total.serveandunser');
        Route::get('/totalgeneralserunserv', [ItemsController::class, 'serveandunsernon'])->name('total.general.serveandunser');
        // Route::get('/category/{id}/items', [ItemsController::class, 'itemsByCategory'])->name('category.items');
        Route::get('/category/{uuid}/items', [ItemsController::class, 'itemsByCategory'])->name('category.items');

    });
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
Route::prefix('items-with-quantites')->group(function () {
    Route::get('/', [ItemWithQuantityController::class, 'index'])->name('view-items-quantities');
    Route::get('/add', [ItemWithQuantityController::class, 'add'])->name('create-items-quantities');
    Route::post('/store', [ItemWithQuantityController::class, 'store'])->name('store-items-quantities');
    Route::get('/edit/{uuid}', [ItemWithQuantityController::class, 'edit'])->name('edit-items-quantities');
    Route::post('/update{uuid}', [ItemWithQuantityController::class, 'update'])->name('update-items-quantities');
    Route::get('/delete{uuid}', [ItemWithQuantityController::class, 'delete'])->name('delete-items-quantities');
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
