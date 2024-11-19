<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
    KategoriMembershipController,
    AdminMembershipController,
    RegisterController,
    LoginController

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

    Route::get('/kategori-membership', [KategoriMembershipController::class, 'index'])->name('kategorimembership.index');
    Route::get('/kategori-membership/create', [KategoriMembershipController::class, 'create'])->name('kategorimembership.create');
    Route::post('/kategori-membership/store', [KategoriMembershipController::class, 'store'])->name('kategorimembership.store');
    Route::get('/kategori-membership/edit/{id}', [KategoriMembershipController::class, 'edit'])->name('kategorimembership.edit');
    Route::put('/kategori-membership/update/{id}', [KategoriMembershipController::class, 'update'])->name('kategorimembership.update');
    Route::delete('/kategori-membership/delete/{id}', [KategoriMembershipController::class, 'destroy'])->name('kategorimembership.destroy');
    
    Route::get('/admin-membership', [AdminMembershipController::class, 'index'])->name('admin.membership.index');
    Route::get('/admin-membership/create', [AdminMembershipController::class, 'create'])->name('admin.membership.create');
    Route::post('/admin-membership/store', [AdminMembershipController::class, 'store'])->name('admin.membership.store');
    Route::get('/admin-membership/edit/{id}', [AdminMembershipController::class, 'edit'])->name('admin.membership.edit');
    Route::put('/admin-membership/update/{id}', [AdminMembershipController::class, 'update'])->name('admin.membership.update');
    Route::delete('/admin-membership/delete/{id}', [AdminMembershipController::class, 'destroy'])->name('admin.membership.destroy');
});
// ADMIN
