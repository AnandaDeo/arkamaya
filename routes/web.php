<?php

use App\Models\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;

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


Route::get('/project-datatable', [ProjectController::class, 'datatable'])->name('project-datatable');
Route::post('/delete-selected', [ProjectController::class, 'deleteSelected'])->name('delete-selected');
Route::resource('/project', ProjectController::class);

Route::get('/client-select2', [ClientController::class, 'select2'])->name('client-select2');
