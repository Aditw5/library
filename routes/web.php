<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetaillController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/dashboard', App\Http\Controllers\DashboardController::class);
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard']);
Route::get('/test_spatie', [App\Http\Controllers\DashboardController::class, 'test_spatie']);

// Route::get('/catalogs', [App\Http\Controllers\CatalogController::class, 'index']);
// Route::get('/catalogs/create', [App\Http\Controllers\CatalogController::class, 'create']);
// Route::post('/catalogs', [App\Http\Controllers\CatalogController::class, 'store']);
// Route::get('/catalogs/{catalog}/edit', [App\Http\Controllers\CatalogController::class, 'edit']);
// Route::put('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'update']);
// Route::delete('/catalogs/{catalog}', [App\Http\Controllers\CatalogController::class, 'destroy']);

// mempersingkat route CRUD lebih singkat
Route::resource('/catalogs', App\Http\Controllers\CatalogController::class);

// Route::get('/publishers', [App\Http\Controllers\PublisherController::class, 'index']);
// Route::get('/publishers/create', [App\Http\Controllers\PublisherController::class, 'create']);
// Route::post('/publishers', [App\Http\Controllers\PublisherController::class, 'store']);
// Route::get('/publishers/{publisher}/edit', [App\Http\Controllers\PublisherController::class, 'edit']);
// Route::put('/publishers/{publisher}', [App\Http\Controllers\PublisherController::class, 'update']);
// Route::delete('/publishers/{publisher}', [App\Http\Controllers\PublisherController::class, 'destroy']);

// mempersingkat route CRUD lebih singkat
Route::resource('/publishers', App\Http\Controllers\PublisherController::class);


Route::resource('/authors', App\Http\Controllers\AuthorController::class);

Route::resource('/members', App\Http\Controllers\MemberController::class);

Route::resource('/books', App\Http\Controllers\BookController::class);

Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}/create', [App\Http\Controllers\TransactionController::class, 'create'])->name('transactions.create');

Route::resource('/transactions_detail', App\Http\Controllers\TransactionDetaillController::class)
    ->except('create', 'edit', 'show');
Route::post('/transaction_detail/store', [TransactionDetaillController::class, 'store'])->name('transaction_detail.store');
Route::put('/transaction_detail/{id}', [TransactionDetaillController::class, 'update'])->name('transaction_detail.update');
Route::delete('/transaction_detail/{id}', [TransactionDetaillController::class, 'destroy'])->name('transaction_detail.destroy');
Route::get('/transaction_detail/{id}/data', [App\Http\Controllers\TransactionDetaillController::class, 'data'])->name('transaction_detail.data');

// route api untuk akses data dari function api
Route::get('/api/authors', [App\Http\Controllers\AuthorController::class, 'api']);
Route::get('/api/publishers', [App\Http\Controllers\PublisherController::class, 'api']);
Route::get('/api/members', [App\Http\Controllers\MemberController::class, 'api']);
Route::get('/api/books', [App\Http\Controllers\BookController::class, 'api']);
Route::get('/api/transactions', [App\Http\Controllers\TransactionController::class, 'api']);



