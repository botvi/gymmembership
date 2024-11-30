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
    AdminMembershipGymController

};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
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
});
// ADMIN

// WEB
Route::get('/', [WebHomeController::class, 'index'])->name('web.home');
Route::get('/transaksi/{id}', [WebHomeController::class, 'transaksi'])->name('web.transaksi');
Route::post('/transaksi', [WebHomeController::class, 'addMembership'])->name('web.store');
Route::get('/transaksi-detail/{id}', [WebHomeController::class, 'transaksi_detail'])->name('web.transaksi_detail');
Route::get('/success/{order_id}', [WebHomeController::class, 'success'])->name('web.success');
// WEB

