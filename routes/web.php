<?php

use App\Http\Controllers\AffectationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkController;
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

Route::prefix('categories')->group(function(){
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
});

Route::prefix('employees')->group(function(){
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::post('/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('/import', [EmployeeController::class, 'import'])->name('employees.import');
    Route::post('/importation', [EmployeeController::class, 'importation'])->name('employees.importation');
    Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');
    Route::get('/unities/{id}', [EmployeeController::class, 'unities'])->name('employees.unities');
});

Route::prefix('settings')->group(function (){

    Route::get('/', [SettingController::class, 'index'])->name('settings');

    Route::get('/type/{id}', [SettingController::class, 'edit_type'])->name('settings.edit.type');
    Route::get('/level/{id}', [SettingController::class, 'edit_level'])->name('settings.edit.level');
    Route::get('/importation', [SettingController::class, 'importation'])->name('settings.importation');

    Route::prefix('types')->group(function(){
        Route::get('/', [EntityTypeController::class, 'index'])->name('settings.types.index');
        Route::post('/store', [EntityTypeController::class, 'store'])->name('settings.types.store');
        Route::post('/update/{id}', [EntityTypeController::class, 'update'])->name('settings.types.update');
        Route::get('/delete/{id}', [EntityTypeController::class, 'delete'])->name('settings.types.delete');
    });

    Route::prefix('levels')->group(function(){
        Route::get('/', [LevelController::class, 'index'])->name('settings.levels.index');
        Route::post('/store', [LevelController::class, 'store'])->name('settings.levels.store');
        Route::post('/update/{id}', [LevelController::class, 'update'])->name('settings.levels.update');
        Route::get('/delete/{id}', [LevelController::class, 'delete'])->name('settings.levels.delete');
    });
});

Route::prefix('diplomas')->group(function(){
    Route::get('/', [DiplomaController::class, 'index'])->name('diplomas.index');
    Route::get('/{id}', [DiplomaController::class, 'show'])->name('diplomas.show');
    Route::post('/store', [DiplomaController::class, 'store'])->name('diplomas.store');
    Route::get('/edit/{id}', [DiplomaController::class, 'edit'])->name('diplomas.edit');
    Route::post('/update/{id}', [DiplomaController::class, 'update'])->name('diplomas.update');
    Route::get('/delete/{id}', [DiplomaController::class, 'delete'])->name('diplomas.delete');
});

Route::prefix('options')->group(function(){
    Route::get('/', [OptionController::class, 'index'])->name('options.index');
    Route::get('/{id}', [OptionController::class, 'show'])->name('options.show');
    Route::post('/store', [OptionController::class, 'store'])->name('options.store');
    Route::post('/import', [OptionController::class, 'import'])->name('options.import');
    Route::get('/edit/{id}', [SettingController::class, 'edit_diploma'])->name('options.edit');
    Route::post('/update/{id}', [OptionController::class, 'update'])->name('options.update');
    Route::get('/delete/{id}', [OptionController::class, 'delete'])->name('options.delete');
});

Route::prefix('works')->group(function(){
    Route::get('/', [WorkController::class, 'index'])->name('works.index');
    Route::post('/store', [WorkController::class, 'store'])->name('works.store');
    Route::get('/{id}', [WorkController::class, 'show'])->name('works.show');
    Route::get('/delete/{id}', [WorkController::class, 'delete'])->name('works.delete');
    Route::post('/importation', [WorkController::class, 'importation'])->name('works.importation');
});

Route::prefix('qualifications')->group(function(){
    Route::get('/', [QualificationController::class, 'index'])->name('qualifications.index');
    Route::post('/store', [QualificationController::class, 'store'])->name('qualifications.store');
    Route::get('/{id}', [QualificationController::class, 'show'])->name('qualifications.show');
    Route::get('/delete/{id}', [QualificationController::class, 'delete'])->name('qualifications.delete');
    Route::post('/importation', [QualificationController::class, 'importation'])->name('qualifications.importation');
});

Route::prefix('competences')->group(function(){
    Route::get('/', [CompetenceController::class, 'index'])->name('competences.index');
    Route::post('/store', [CompetenceController::class, 'store'])->name('competences.store');
    Route::get('/{id}', [CompetenceController::class, 'show'])->name('competences.show');
    Route::get('/delete/{id}', [CompetenceController::class, 'delete'])->name('competences.delete');
});

Route::prefix('affectations')->group(function(){
    Route::get('/', [AffectationController::class, 'index'])->name('affectations.index');
    Route::post('/store', [AffectationController::class, 'store'])->name('affectations.store');
    Route::get('/{id}', [AffectationController::class, 'show'])->name('affectations.show');
    Route::get('/edit/{employee_id}/{affectation_id}', [AffectationController::class, 'edit'])->name('affectations.edit');
    Route::post('/update/{id}', [AffectationController::class, 'update'])->name('affectations.update');
    Route::get('/delete/{id}', [AffectationController::class, 'delete'])->name('affectations.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
