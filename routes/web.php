<?php

use App\Http\Controllers\BudgetEntryController;
use App\Http\Controllers\BudgetHeaderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExpenseEntryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Models\BudgetHeader;
use App\Models\VWBudgetEntry;
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
    return view('login');
});

Route::middleware('auth')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
    });

    Route::controller(BudgetHeaderController::class)->group(function () {
        Route::get('/budget_headers', 'index')->name('budget_headers');
        Route::post('/budget_headers', 'store')->name('budget_headers.store');
        Route::put('/budget_headers', 'update')->name('budget_headers.update');
        Route::post('/budget_headers_destroy', 'destroy')->name('budget_headers.destroy');
    });

    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/departments', 'index')->name('departments');
        Route::post('/departments', 'store')->name('departments.store');
        Route::put('/departments', 'update')->name('departments.update');
        Route::post('/departments_destroy', 'destroy')->name('departments.destroy');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories');
        Route::post('/categories', 'store')->name('categories.store');
        Route::put('/categories', 'update')->name('categories.update');
        Route::post('/categories_destroy', 'destroy')->name('categories.destroy');
    });

    Route::controller(BudgetEntryController::class)->group(function () {
        Route::get('/budget_entries', 'index')->name('budget_entries');
        Route::post('/budget_entries', 'store')->name('budget_entries.store');
        Route::put('/budget_entries', 'update')->name('budget_entries.update');
        Route::post('/budget_entries_destroy', 'destroy')->name('budget_entries.destroy');
    });

    Route::controller(ExpenseEntryController::class)->group(function () {
        Route::get('/request_entries', 'index')->name('request_entries');
        Route::post('/request_entries', 'store')->name('request_entries.store');
        Route::put('/request_entries', 'update')->name('request_entries.update');
        Route::post('/request_entries_destroy', 'destroy')->name('request_entries.destroy');

        Route::get('/expense_entries', 'indexExpense')->name('expense_entries');
//        Route::post('/expense_entries', 'storeExpense')->name('expense_entries.store');
        Route::put('/expense_entries', 'updateExpense')->name('expense_entries.update');
        Route::post('/expense_entries_destroy', 'destroyExpense')->name('expense_entries.destroy');
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/reports', 'index')->name('reports');
        Route::post('/reports_output', 'generate')->name('generate.reports');

        Route::get('export/{type}/{id}', 'export')->name('export');
        Route::get('exportPdf/{type}/{id}', 'exportToPdf')->name('export_pdf');
    });
});

Route::get('get_budget_entry', [BudgetEntryController::class, 'getBudgetEntry']);

require __DIR__.'/auth.php';
