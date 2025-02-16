<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
    RegisterController,
    LoginController,
    WebHomeController,
    ListBoxingMuaythaiController,
    ListPackageController,
    ListForeachTimeVisitController,
    ListMembershipGymController,
    AdminMembershipGymController,
    AdminBoxingMuaythaiController,
    AdminPackageController,
    AdminPerVisitController,
    MidtransMembershipGymController,
    MidtransBoxingMuaythaiController,
    MidtransPackageController,
    MidtransPerVisitController,
    ManagePerVisitController,
    ManageMembershipGymController,
    ManageBoxingMuaythaiController,
    ManagePackageController,
    EventController,
    CronjobsController
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// CRONJOBS
Route::get('/cronjobs/check', [CronjobsController::class, 'checkAndUpdateAllMembershipStatus'])->name('admin.manage_membership.check');
// CRONJOBS

Route::get('/run-admin', function () {
    Artisan::call('db:seed', [
        '--class' => 'UsersTableSeeder'
    ]);

    return "AdminSeeder has been create successfully!";
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN
Route::group(['middleware' => ['role:admin']], function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/edit/{id}', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/update/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/delete/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/list-membership-gym', [ListMembershipGymController::class, 'index'])->name('listmembershipgym.index');
    Route::get('/list-membership-gym/create', [ListMembershipGymController::class, 'create'])->name('listmembershipgym.create');
    Route::post('/list-membership-gym/store', [ListMembershipGymController::class, 'store'])->name('listmembershipgym.store');
    Route::get('/list-membership-gym/edit/{id}', [ListMembershipGymController::class, 'edit'])->name('listmembershipgym.edit');
    Route::put('/list-membership-gym/update/{id}', [ListMembershipGymController::class, 'update'])->name('listmembershipgym.update');
    Route::delete('/list-membership-gym/delete/{id}', [ListMembershipGymController::class, 'destroy'])->name('listmembershipgym.destroy');
    
    Route::get('/list-boxing-muaythai', [ListBoxingMuaythaiController::class, 'index'])->name('listboxingmuaythai.index');
    Route::get('/list-boxing-muaythai/create', [ListBoxingMuaythaiController::class, 'create'])->name('listboxingmuaythai.create');
    Route::post('/list-boxing-muaythai/store', [ListBoxingMuaythaiController::class, 'store'])->name('listboxingmuaythai.store');
    Route::get('/list-boxing-muaythai/edit/{id}', [ListBoxingMuaythaiController::class, 'edit'])->name('listboxingmuaythai.edit');
    Route::put('/list-boxing-muaythai/update/{id}', [ListBoxingMuaythaiController::class, 'update'])->name('listboxingmuaythai.update');
    Route::delete('/list-boxing-muaythai/delete/{id}', [ListBoxingMuaythaiController::class, 'destroy'])->name('listboxingmuaythai.destroy');

    Route::get('/list-package', [ListPackageController::class, 'index'])->name('listpackage.index');
    Route::get('/list-package/create', [ListPackageController::class, 'create'])->name('listpackage.create');
    Route::post('/list-package/store', [ListPackageController::class, 'store'])->name('listpackage.store');
    Route::get('/list-package/edit/{id}', [ListPackageController::class, 'edit'])->name('listpackage.edit');
    Route::put('/list-package/update/{id}', [ListPackageController::class, 'update'])->name('listpackage.update');
    Route::delete('/list-package/delete/{id}', [ListPackageController::class, 'destroy'])->name('listpackage.destroy');

    Route::get('/list-foreach-time-visit', [ListForeachTimeVisitController::class, 'index'])->name('listforeachtimevisit.index');
    Route::get('/list-foreach-time-visit/create', [ListForeachTimeVisitController::class, 'create'])->name('listforeachtimevisit.create');
    Route::post('/list-foreach-time-visit/store', [ListForeachTimeVisitController::class, 'store'])->name('listforeachtimevisit.store');  
    Route::get('/list-foreach-time-visit/edit/{id}', [ListForeachTimeVisitController::class, 'edit'])->name('listforeachtimevisit.edit');
    Route::put('/list-foreach-time-visit/update/{id}', [ListForeachTimeVisitController::class, 'update'])->name('listforeachtimevisit.update');
    Route::delete('/list-foreach-time-visit/delete/{id}', [ListForeachTimeVisitController::class, 'destroy'])->name('listforeachtimevisit.destroy');

    Route::get('/admin-membership-gym', [AdminMembershipGymController::class, 'index'])->name('admin.membership_gym.index');
    Route::get('/admin-membership-gym/create', [AdminMembershipGymController::class, 'create'])->name('admin.membership_gym.create');
    Route::post('/admin-membership-gym/store', [AdminMembershipGymController::class, 'store'])->name('admin.membership_gym.store'); 
    Route::get('/admin-membership-gym/edit/{id}', [AdminMembershipGymController::class, 'edit'])->name('admin.membership_gym.edit');
    Route::put('/admin-membership-gym/update/{id}', [AdminMembershipGymController::class, 'update'])->name('admin.membership_gym.update');
    Route::delete('/admin-membership-gym/delete/{id}', [AdminMembershipGymController::class, 'destroy'])->name('admin.membership_gym.destroy');

    Route::get('/admin-boxing-muaythai', [AdminBoxingMuaythaiController::class, 'index'])->name('admin.boxing_muaythai.index');
    Route::get('/admin-boxing-muaythai/create', [AdminBoxingMuaythaiController::class, 'create'])->name('admin.boxing_muaythai.create');
    Route::post('/admin-boxing-muaythai/store', [AdminBoxingMuaythaiController::class, 'store'])->name('admin.boxing_muaythai.store'); 
    Route::get('/admin-boxing-muaythai/edit/{id}', [AdminBoxingMuaythaiController::class, 'edit'])->name('admin.boxing_muaythai.edit');
    Route::put('/admin-boxing-muaythai/update/{id}', [AdminBoxingMuaythaiController::class, 'update'])->name('admin.boxing_muaythai.update');
    Route::delete('/admin-boxing-muaythai/delete/{id}', [AdminBoxingMuaythaiController::class, 'destroy'])->name('admin.boxing_muaythai.destroy');

    Route::get('/admin-package', [AdminPackageController::class, 'index'])->name('admin.package.index');
    Route::get('/admin-package/create', [AdminPackageController::class, 'create'])->name('admin.package.create');
    Route::post('/admin-package/store', [AdminPackageController::class, 'store'])->name('admin.package.store'); 
    Route::get('/admin-package/edit/{id}', [AdminPackageController::class, 'edit'])->name('admin.package.edit');
    Route::put('/admin-package/update/{id}', [AdminPackageController::class, 'update'])->name('admin.package.update');
    Route::delete('/admin-package/delete/{id}', [AdminPackageController::class, 'destroy'])->name('admin.package.destroy');

    Route::get('/admin-per-visit', [AdminPerVisitController::class, 'index'])->name('admin.per_visit.index');
    Route::get('/admin-per-visit/create', [AdminPerVisitController::class, 'create'])->name('admin.per_visit.create');
    Route::post('/admin-per-visit/store', [AdminPerVisitController::class, 'store'])->name('admin.per_visit.store');
    Route::get('/admin-per-visit/edit/{id}', [AdminPerVisitController::class, 'edit'])->name('admin.per_visit.edit');
    Route::put('/admin-per-visit/update/{id}', [AdminPerVisitController::class, 'update'])->name('admin.per_visit.update');
    Route::delete('/admin-per-visit/delete/{id}', [AdminPerVisitController::class, 'destroy'])->name('admin.per_visit.destroy');

    Route::get('/admin-manage-per-visit', [ManagePerVisitController::class, 'index'])->name('admin.manage_per_visit.index');
    Route::get('/admin-manage-per-visit/update/{id}', [ManagePerVisitController::class, 'updateStatusKehadiran'])->name('admin.manage_per_visit.update_status_kehadiran');

    Route::get('/admin-manage-membership-gym', [ManageMembershipGymController::class, 'index'])->name('admin.manage_membership_gym.index');
    Route::get('/admin-manage-membership-gym/check', [ManageMembershipGymController::class, 'checkAndUpdateMembershipStatus'])->name('admin.manage_membership_gym.check');

    Route::get('/admin-manage-boxing-muaythai', [ManageBoxingMuaythaiController::class, 'index'])->name('admin.manage_boxing_muaythai.index');
    Route::get('/admin-manage-boxing-muaythai/update/{id}', [ManageBoxingMuaythaiController::class, 'updateSessionCount'])->name('admin.manage_boxing_muaythai.update_session_count');

    Route::get('/admin-manage-package', [ManagePackageController::class, 'index'])->name('admin.manage_package.index');
    Route::get('/admin-manage-package/update/{id}', [ManagePackageController::class, 'updateSessionCount'])->name('admin.manage_package.update_session_count'); 
    Route::get('/admin-manage-package/check', [ManagePackageController::class, 'checkAndUpdateMembershipStatus'])->name('admin.manage_package.check');
});
// ADMIN

// WEB
Route::get('/', [WebHomeController::class, 'index'])->name('web.home');
Route::get('/detail-membership/{id}', [WebHomeController::class, 'detailMembership'])->name('web.detail_membership');
Route::get('/detail-boxing-muaythai/{id}', [WebHomeController::class, 'detailBoxingMuayThai'])->name('web.detail_boxing_muaythai');
Route::get('/detail-package/{id}', [WebHomeController::class, 'detailPackage'])->name('web.detail_package');
Route::get('/detail-foreach-time-visit/{id}', [WebHomeController::class, 'detailForeachTimeVisit'])->name('web.detail_foreach_time_visit');


// PAYMENT
Route::post('/transaksi-membership-gym', [MidtransMembershipGymController::class, 'addMembership'])->name('web.store_membership_gym');
Route::get('/transaksi-membership-gym-detail/{id}', [MidtransMembershipGymController::class, 'transaksi_detail'])->name('web.transaksi_detail_membership_gym');
Route::get('/success-membership-gym/{order_id}', [MidtransMembershipGymController::class, 'success'])->name('web.success_membership_gym');

Route::post('/transaksi-boxing-muaythai', [MidtransBoxingMuaythaiController::class, 'addBoxingMuaythai'])->name('web.store_boxing_muaythai');
Route::get('/transaksi-boxing-muaythai-detail/{id}', [MidtransBoxingMuaythaiController::class, 'transaksi_detail'])->name('web.transaksi_detail_boxing_muaythai');
Route::get('/success-boxing-muaythai/{order_id}', [MidtransBoxingMuaythaiController::class, 'success'])->name('web.success_boxing_muaythai');

Route::post('/transaksi-package', [MidtransPackageController::class, 'addPackage'])->name('web.store_package');
Route::get('/transaksi-package-detail/{id}', [MidtransPackageController::class, 'transaksi_detail'])->name('web.transaksi_detail_package');
Route::get('/success-package/{order_id}', [MidtransPackageController::class, 'success'])->name('web.success_package');

Route::post('/transaksi-per-visit', [MidtransPerVisitController::class, 'addPerVisit'])->name('web.store_per_visit');
Route::get('/transaksi-per-visit-detail/{id}', [MidtransPerVisitController::class, 'transaksi_detail'])->name('web.transaksi_detail_per_visit');
Route::get('/success-per-visit/{order_id}', [MidtransPerVisitController::class, 'success'])->name('web.success_per_visit');
// PAYMENT




// WEB


