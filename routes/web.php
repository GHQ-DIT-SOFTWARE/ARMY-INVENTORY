<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DefaultInventoryController;
use App\Http\Controllers\IssueItemOutController;
use App\Http\Controllers\ItemIssuingController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\ManageUserAccountController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\personnelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\rankController;
use App\Http\Controllers\RestockItemController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\G4DashController;
use App\Http\Controllers\ArmoryController;
use App\Http\Controllers\WeaponCategoryController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\WeaponInventoryController;
use App\Http\Controllers\WeaponIssueController;
use App\Http\Controllers\WeaponIssueSummaryController;
use App\Http\Controllers\WeaponDashboardController;
use App\Http\Controllers\MotorPoolController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleInventoryController;
use App\Http\Controllers\VehicleDeploymentController;
use App\Http\Controllers\VehicleDashboardController;
use App\Http\Controllers\VehicleDeploymentSummaryController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/admin/g4-dash', [G4DashController::class, 'index'])->name('admin.g4.dash');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'), 'verified', 'otp.verify', 'force.password.change',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::post('login', [PagesController::class, 'Log_in'])->name('login.dashboard');
Route::get('logout', [PagesController::class, 'Logout'])->name('logout');
Route::post('passwaord/reset', [PagesController::class, 'Resetpassword'])->name('password.update.reset');
Route::get('/verify/otp', [OTPController::class, 'showVerifyOtpForm'])->name('verify.otp');
Route::post('/verify/otp', [OTPController::class, 'verifyOtp'])->name('otp.verify');

Route::middleware(['auth'])->group(function () {
    Route::post('/password-changed', [ManageUserAccountController::class, 'changePassword'])->name('changed-password');
    Route::get('/change-password', [PagesController::class, 'verifyaccount'])->name('verify-password');
    Route::get('/generalinactive{id}', [PagesController::class, 'Inactive'])->name('user.inactive');
    Route::get('/generalactive{id}', [PagesController::class, 'Active'])->name('user.active');
    Route::get('/items-info', [DashboardController::class, 'View'])->name('home.dash');
    Route::get('/history', [DashboardController::class, 'Historytable'])->name('history.dash');
    Route::get('/log-activities', [LogactivityController::class, 'login_and_logout_activities'])->name('login_and_logout_activities');
    Route::prefix('AuditTrail')->group(function () {
        Route::get('/audittrail', [AuditController::class, 'ViewAudit'])->name('audit.trail');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesAndPermissionController::class, 'index'])->name('index-roles');
        Route::get('/add', [RolesAndPermissionController::class, 'create_role'])->name('create-roles');
        Route::post('/store', [RolesAndPermissionController::class, 'store'])->name('store-roles');
        Route::get('/edit/{uuid}', [RolesAndPermissionController::class, 'edit'])->name('edit-roles');
        Route::post('/update', [RolesAndPermissionController::class, 'update'])->name('update-roles');
        Route::get('/delete{uuid}', [RolesAndPermissionController::class, 'destroy'])->name('destroy-roles');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserAccountController::class, 'index'])->name('index-user');
        Route::get('/add', [UserAccountController::class, 'create'])->name('create-user');
        Route::post('/store', [UserAccountController::class, 'store'])->name('store-user');
        Route::get('/edit/{uuid}', [UserAccountController::class, 'edit'])->name('edit-user');
        Route::post('/update', [UserAccountController::class, 'update'])->name('update-user');
        Route::get('/delete{uuid}', [UserAccountController::class, 'destroy'])->name('destroy-user');
    });
    Route::prefix('Profile')->group(function () {
        Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profileview');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
    });

    Route::prefix('item')->group(function () {
        Route::get('/category', [CategoryController::class, 'View'])->name('view-index');
        Route::get('/category/create', [CategoryController::class, 'AddCate'])->name('create');
        Route::post('/category/store', [CategoryController::class, 'Store'])->name('store-category');
        Route::get('/category/edit/{uuid}', [CategoryController::class, 'Edit'])->name('edit-category');
        Route::post('/category/update', [CategoryController::class, 'Update'])->name('update-category');
        Route::get('/category/delete/{uuid}', [CategoryController::class, 'Delete'])->name('delete-category');

        Route::get('/sub-category', [SubCategoryController::class, 'View'])->name('view-subcategory');
        Route::get('/sub-category/create', [SubCategoryController::class, 'Add'])->name('add-subcategory');
        Route::post('/sub-category/store', [SubCategoryController::class, 'Store'])->name('store-subcategory');
        Route::get('/sub-category/edit/{uuid}', [SubCategoryController::class, 'Edit'])->name('edit-subcategory');
        Route::post('/sub-category/update/{uuid}', [SubCategoryController::class, 'Update'])->name('update-subcategory');
        Route::get('/sub-category/delete/{uuid}', [SubCategoryController::class, 'Delete'])->name('delete-subcategory');

        Route::get('/suppliers', [SupplierController::class, 'Index'])->name('viewsupp');
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('supadd');
        Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('supstore');
        Route::get('/suppliers/{uuid}/edit', [SupplierController::class, 'Edit'])->name('supedit');
        Route::post('/suppliers/{uuid}/update', [SupplierController::class, 'update'])->name('supupa');
        Route::get('/suppliers/{uuid}/delete', [SupplierController::class, 'delete'])->name('supdel');

        Route::get('/restocks', [RestockItemController::class, 'purchase_index'])->name('viewpurchase');
        Route::get('/restocks/create', [RestockItemController::class, 'purchase_create'])->name('addpurchase');
        Route::post('/restocks/store', [RestockItemController::class, 'purchase_store'])->name('storepurchase');
        Route::get('/restocks/{uuid}/delete', [RestockItemController::class, 'purchase_delete'])->name('deletepurchase');
        Route::prefix('unit')->group(function () {
            Route::get('/view', [UnitController::class, 'View'])->name('view-unit');
            Route::get('/add', [UnitController::class, 'Add'])->name('add-unit');
            Route::post('/store', [UnitController::class, 'Store'])->name('store-unit');
            Route::get('/edit/{uuid}', [UnitController::class, 'Edit'])->name('edit-unit');
            Route::post('/update/{uuid}', [UnitController::class, 'Update'])->name('update-unit');
            Route::get('/delete/{uuid}', [UnitController::class, 'Delete'])->name('delete-unit');
            Route::post('/import', [UnitController::class, 'import'])->name('import-units');
        });

        Route::prefix('sub-category')->group(function () {
            Route::get('/get-subcategory/{categoryId}', [DefaultInventoryController::class, 'fetchSubCategory'])->name('get-subcategory');
            Route::get('/fetch-category-and-subcategory/{itemId}', [DefaultInventoryController::class, 'fetchCategoryAndSubcategory'])->name('fetch-category-and-subcategory');
        });
        Route::get('/', [ItemsController::class, 'View'])->name('view-item');
        Route::get('/item-manager', [ItemsController::class, 'manage_item'])->name('manage_item');
        Route::get('/add', [ItemsController::class, 'Add'])->name('add-item');
        Route::post('/store', [ItemsController::class, 'Store'])->name('store-item');
        Route::get('/edit/{uuid}', [ItemsController::class, 'Edit'])->name('edit-item');
        Route::post('/update/{uuid}', [ItemsController::class, 'Update'])->name('update-item');
        Route::get('/delete/{uuid}', [ItemsController::class, 'Delete'])->name('delete-item');

        Route::get('/get-issue-subcategory/{categoryId}', [ItemsController::class, 'getSubCategory'])->name('get-issue-subcategory');
        Route::get('/get-items/{subCategoryId}', [ItemsController::class, 'getItems'])->name('get-items');
        Route::get('/get-sizes/{itemId}', [ItemsController::class, 'getSizes'])->name('get-sizes');
        Route::get('/get-quantity/{sizeId}', [ItemsController::class, 'getQuantity'])->name('get-quantity');
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

        Route::prefix('controls')->name('controls.')->group(function () {
            Route::prefix('general-items')->name('general-items.')->group(function () {
                Route::get('/issue', [ItemIssuingController::class, 'CreateGeneralItem'])->name('issue');
                Route::post('/issue', [ItemIssuingController::class, 'GeneralItemStore'])->name('issue.store');
                Route::get('/issued', [ItemIssuingController::class, 'generalIssuedItems'])->name('issued');
                Route::get('/returns', [ItemIssuingController::class, 'generalReturnQueue'])->name('returns');
                Route::get('/returned', [ItemIssuingController::class, 'generalReturnedItems'])->name('returned');
                Route::get('/issues/{id}', [ItemIssuingController::class, 'generalIssueDetails'])->name('show');
                Route::get('/issues/{id}/reissue', [ItemIssuingController::class, 'generalReissueForm'])->name('reissue.form');
                Route::post('/issues/{id}/reissue', [ItemIssuingController::class, 'generalReissue'])->name('reissue');
                Route::get('/records', [ItemIssuingController::class, 'GeneralItemView'])->name('records');

                Route::get('/mark-returned/{id}', [ItemIssuingController::class, 'GeneralonLoan'])->name('mark-returned');
                Route::get('/mark-loaned/{id}', [ItemIssuingController::class, 'GeneralReturn'])->name('mark-loaned');
            });
        });

        Route::prefix('weapons')->name('weapons.')->group(function () {
            Route::get('/dashboard', WeaponDashboardController::class)->name('dashboard');
            Route::get('issues/summary', WeaponIssueSummaryController::class)->name('issues.summary');

            Route::resource('categories', WeaponCategoryController::class)->parameters([
                'categories' => 'weaponCategory',
            ])->except(['show']);
            Route::resource('platforms', WeaponController::class)->parameters(['platforms' => 'weapon'])->except(['show']);
            Route::resource('inventory', WeaponInventoryController::class)->except(['show']);
            Route::resource('armories', ArmoryController::class)->except(['show']);

            Route::get('issues/create', [WeaponIssueController::class, 'create'])->name('issues.create');
            Route::post('issues', [WeaponIssueController::class, 'store'])->name('issues.store');
            Route::get('issues/search', [WeaponIssueController::class, 'search'])->name('issues.search');
            Route::get('issues/track', [WeaponIssueController::class, 'track'])->name('issues.track');

            Route::get('returns', [WeaponIssueController::class, 'returnForm'])->name('returns.form');
            Route::post('returns', [WeaponIssueController::class, 'processReturn'])->name('returns.process');
        });
        Route::prefix('vehicles')->name('vehicles.')->group(function () {
            Route::get('/dashboard', VehicleDashboardController::class)->name('dashboard');
            Route::get('deployments/summary', VehicleDeploymentSummaryController::class)->name('deployments.summary');

            Route::resource('categories', VehicleCategoryController::class)->parameters([
                'categories' => 'vehicleCategory',
            ])->except(['show']);
            Route::resource('motor-pools', MotorPoolController::class)->parameters([
                'motor-pools' => 'motorPool',
            ])->except(['show']);
            Route::resource('platforms', VehicleController::class)->parameters([
                'platforms' => 'vehicle',
            ])->except(['show']);
            Route::resource('inventory', VehicleInventoryController::class)->parameters([
                'inventory' => 'vehicleInventory',
            ])->except(['show']);

            Route::get('deployments/create', [VehicleDeploymentController::class, 'create'])->name('deployments.create');
            Route::post('deployments', [VehicleDeploymentController::class, 'store'])->name('deployments.store');
            Route::get('deployments/track', [VehicleDeploymentController::class, 'track'])->name('deployments.track');

            Route::get('returns', [VehicleDeploymentController::class, 'returnForm'])->name('returns.form');
            Route::post('returns', [VehicleDeploymentController::class, 'processReturn'])->name('returns.process');
        });

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

Route::prefix('personnel')->group(function () {
    Route::get('/', [personnelController::class, 'index'])->name('personal-view');
    Route::get('/mech', [personnelController::class, 'create'])->name('personal-mech');
    Route::post('/store', [personnelController::class, 'store'])->name('personal-store');
    Route::get('/edit/{uuid}', [personnelController::class, 'edit'])->name('personal-edit');
    Route::post('/update', [personnelController::class, 'update'])->name('personal-update');
    Route::get('/delete{uuid}', [personnelController::class, 'delete'])->name('personal-delete');
    Route::post('/import', [personnelController::class, 'import'])->name('import-personnel');
    Route::get('/download-sample-excel', [personnelController::class, 'downloadSampleExcel']);
    Route::get('/size-report', [personnelController::class, 'showSizeReport'])->name('personnel.size-report');
    Route::get('/size-report/data', [personnelController::class, 'getSizeReportData'])->name('personnel.size.report.data');
});
Route::get('/profile/{uuid}', [personnelController::class, 'showProfile'])->name('personnel.profile');
