<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalCount = \App\Models\Todo::count();
    $notStartedCount = \App\Models\Todo::where('status', 'Not Started')->count();
    $inProgressCount = \App\Models\Todo::where('status', 'In Progress')->count();
    $completedCount = \App\Models\Todo::where('status', 'Completed')->count();
    $cancelledCount = \App\Models\Todo::where('status', 'Cancelled')->count();

    return view('dashboard', compact('totalCount', 'notStartedCount', 'inProgressCount', 'completedCount', 'cancelledCount'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('todos', TodoController::class);
});

require __DIR__.'/auth.php';