<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    Route::resource('/category', App\Http\Controllers\CategoryController::class);
    Route::resource('/author', App\Http\Controllers\AuthorController::class);
    Route::resource('/publisher', App\Http\Controllers\PublisherController::class);
    Route::resource('/book', App\Http\Controllers\BookController::class);
    Route::post('/book/{book}/copy', [App\Http\Controllers\BookCopyController::class, 'store'])->name('book.copy.store');
    Route::put('/book/{book}/copy/{copy}', [App\Http\Controllers\BookCopyController::class, 'update'])->name('book.copy.update');
    Route::delete('/book/{book}/copy/{copy}', [App\Http\Controllers\BookCopyController::class, 'destroy'])->name('book.copy.destroy');
    Route::resource('/member', App\Http\Controllers\MemberController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/borrowing', App\Http\Controllers\BorrowingController::class);
    Route::put('/borrowing/{borrowing}/return', [App\Http\Controllers\BorrowingController::class, 'returnBook'])->name('borrowing.return');
    Route::get('/fine', [App\Http\Controllers\FineController::class, 'index'])->name('fine.index');
    Route::put('/fine/{fine}/pay', [App\Http\Controllers\FineController::class, 'pay'])->name('fine.pay');
    
    Route::get('/reservation', [App\Http\Controllers\BookReservationController::class, 'index'])->name('reservation.index');
    Route::post('/reservation', [App\Http\Controllers\BookReservationController::class, 'store'])->name('reservation.store');
    Route::put('/reservation/{reservation}/cancel', [App\Http\Controllers\BookReservationController::class, 'cancel'])->name('reservation.cancel');
    
    Route::post('/review', [App\Http\Controllers\BookReviewController::class, 'store'])->name('review.store');

    Route::get('/riwayat', [App\Http\Controllers\MemberHistoryController::class, 'index'])->name('riwayat.index');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
