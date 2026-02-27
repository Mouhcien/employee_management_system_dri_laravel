<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard0', function () {
    return view('app.dashboard');
})->name('dashboard0');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('cities')->group(function(){
    Route::get('/', [CityController::class, 'index'])->name('cities.index');
    Route::get('/create', [CityController::class, 'create'])->name('cities.create');
    Route::get('/store', [CityController::class, 'create'])->name('cities.store');
    Route::get('/show/{id}', [CityController::class, 'show'])->name('cities.show');
    Route::get('/edit/{id}', [CityController::class, 'create'])->name('cities.edit');
    Route::get('/update/{id}', [CityController::class, 'create'])->name('cities.update');
    Route::get('/delete/{id}', [CityController::class, 'create'])->name('cities.delete');
});

Route::prefix('locals')->group(function(){
    Route::get('/', [LocalController::class, 'index'])->name('locals.index');
    Route::get('/create', [LocalController::class, 'create'])->name('locals.create');
    Route::get('/store', [LocalController::class, 'create'])->name('locals.store');
    Route::get('/edit/{id}', [LocalController::class, 'create'])->name('locals.edit');
    Route::get('/update/{id}', [LocalController::class, 'create'])->name('locals.update');
    Route::get('/delete/{id}', [LocalController::class, 'create'])->name('locals.delete');
});

Route::prefix('services')->group(function(){
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
    Route::get('/store', [ServiceController::class, 'create'])->name('services.store');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/edit/{id}', [ServiceController::class, 'create'])->name('services.edit');
    Route::get('/update/{id}', [ServiceController::class, 'create'])->name('services.update');
    Route::get('/delete/{id}', [ServiceController::class, 'create'])->name('services.delete');
});

Route::prefix('entities')->group(function(){
    Route::get('/', [EntityController::class, 'index'])->name('entities.index');
    Route::get('/create', [EntityController::class, 'create'])->name('entities.create');
    Route::get('/store', [EntityController::class, 'create'])->name('entities.store');
    Route::get('/edit/{id}', [EntityController::class, 'create'])->name('entities.edit');
    Route::get('/update/{id}', [EntityController::class, 'create'])->name('entities.update');
    Route::get('/delete/{id}', [EntityController::class, 'create'])->name('entities.delete');
});

Route::prefix('sectors')->group(function(){
    Route::get('/', [SectorController::class, 'index'])->name('sectors.index');
    Route::get('/create', [SectorController::class, 'create'])->name('sectors.create');
    Route::get('/store', [SectorController::class, 'create'])->name('sectors.store');
    Route::get('/edit/{id}', [SectorController::class, 'create'])->name('sectors.edit');
    Route::get('/update/{id}', [SectorController::class, 'create'])->name('sectors.update');
    Route::get('/delete/{id}', [SectorController::class, 'create'])->name('sectors.delete');
});

Route::prefix('sections')->group(function(){
    Route::get('/', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/create', [SectionController::class, 'create'])->name('sections.create');
    Route::get('/store', [SectionController::class, 'create'])->name('sections.store');
    Route::get('/edit/{id}', [SectionController::class, 'create'])->name('sections.edit');
    Route::get('/update/{id}', [SectionController::class, 'create'])->name('sections.update');
    Route::get('/delete/{id}', [SectionController::class, 'create'])->name('sections.delete');
});

Route::prefix('types')->group(function(){
    Route::get('/', [EntityTypeController::class, 'index'])->name('types.index');
    Route::get('/create', [EntityTypeController::class, 'create'])->name('types.create');
    Route::get('/store', [EntityTypeController::class, 'create'])->name('types.store');
    Route::get('/edit/{id}', [EntityTypeController::class, 'create'])->name('types.edit');
    Route::get('/update/{id}', [EntityTypeController::class, 'create'])->name('types.update');
    Route::get('/delete/{id}', [EntityTypeController::class, 'create'])->name('types.delete');
});

Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
