<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
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
    Route::post('/store', [CityController::class, 'store'])->name('cities.store');
    Route::get('/show/{id}', [CityController::class, 'show'])->name('cities.show');
    Route::get('/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
    Route::post('/update/{id}', [CityController::class, 'update'])->name('cities.update');
    Route::get('/delete/{id}', [CityController::class, 'delete'])->name('cities.delete');
});

Route::prefix('locals')->group(function(){
    Route::get('/', [LocalController::class, 'index'])->name('locals.index');
    Route::post('/store', [LocalController::class, 'store'])->name('locals.store');
    Route::get('/{id}', [LocalController::class, 'show'])->name('locals.show');
    Route::post('/update/{id}', [LocalController::class, 'update'])->name('locals.update');
    Route::get('/delete/{id}', [LocalController::class, 'delete'])->name('locals.delete');
});

Route::prefix('services')->group(function(){
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::post('/update/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::get('/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
});

Route::prefix('entities')->group(function(){
    Route::get('/', [EntityController::class, 'index'])->name('entities.index');
    Route::get('/create', [EntityController::class, 'create'])->name('entities.create');
    Route::post('/store', [EntityController::class, 'store'])->name('entities.store');
    Route::get('/{id}', [EntityController::class, 'show'])->name('entities.show');
    Route::get('/edit/{id}', [EntityController::class, 'edit'])->name('entities.edit');
    Route::post('/update/{id}', [EntityController::class, 'update'])->name('entities.update');
    Route::get('/delete/{id}', [EntityController::class, 'delete'])->name('entities.delete');
});

Route::prefix('sectors')->group(function(){
    Route::get('/', [SectorController::class, 'index'])->name('sectors.index');
    Route::get('/create', [SectorController::class, 'create'])->name('sectors.create');
    Route::post('/store', [SectorController::class, 'store'])->name('sectors.store');
    Route::get('/{id}', [SectorController::class, 'show'])->name('sectors.show');
    Route::get('/edit/{id}', [SectorController::class, 'edit'])->name('sectors.edit');
    Route::post('/update/{id}', [SectorController::class, 'update'])->name('sectors.update');
    Route::get('/delete/{id}', [SectorController::class, 'delete'])->name('sectors.delete');
});

Route::prefix('sections')->group(function(){
    Route::get('/', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/store', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/{id}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('sections.edit');
    Route::post('/update/{id}', [SectionController::class, 'update'])->name('sections.update');
    Route::get('/delete/{id}', [SectionController::class, 'delete'])->name('sections.delete');
});

Route::prefix('occupations')->group(function(){
    Route::get('/', [OccupationController::class, 'index'])->name('occupations.index');
    Route::get('/create', [OccupationController::class, 'create'])->name('occupations.create');
    Route::post('/store', [OccupationController::class, 'store'])->name('occupations.store');
    Route::get('/{id}', [OccupationController::class, 'show'])->name('occupations.show');
    Route::get('/edit/{id}', [OccupationController::class, 'edit'])->name('occupations.edit');
    Route::post('/update/{id}', [OccupationController::class, 'update'])->name('occupations.update');
    Route::get('/delete/{id}', [OccupationController::class, 'delete'])->name('occupations.delete');
});

Route::prefix('grades')->group(function(){
    Route::get('/', [GradeController::class, 'index'])->name('grades.index');
    Route::get('/create', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/store', [GradeController::class, 'store'])->name('grades.store');
    Route::get('/{id}', [GradeController::class, 'show'])->name('grades.show');
    Route::get('/edit/{id}', [GradeController::class, 'edit'])->name('grades.edit');
    Route::post('/update/{id}', [GradeController::class, 'update'])->name('grades.update');
    Route::get('/delete/{id}', [GradeController::class, 'delete'])->name('grades.delete');
});

Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
});

Route::prefix('settings')->group(function (){
    Route::get('/', [SettingController::class, 'index'])->name('settings');

    Route::prefix('types')->group(function(){
        Route::get('/', [EntityTypeController::class, 'index'])->name('settings.types.index');
        Route::post('/store', [EntityTypeController::class, 'store'])->name('settings.types.store');
        Route::get('/edit/{id}', [EntityTypeController::class, 'edit'])->name('settings.types.edit');
        Route::post('/update/{id}', [EntityTypeController::class, 'update'])->name('settings.types.update');
        Route::get('/delete/{id}', [EntityTypeController::class, 'delete'])->name('settings.types.delete');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
