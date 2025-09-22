<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MainController;
use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'main'])->name('main');

// Auth Route
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard')->middleware('role:Operator|Administrator|MeGGi');
  Route::get('/test', [MainController::class, 'dashboard'])->name('test')->middleware('role:Operator|Administrator|MeGGi');
  Route::get('/awok', Dashboard::class)->name('awok')->middleware('role:Operator|Administrator|MeGGi');
});
