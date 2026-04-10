<?php

use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\CompetenceController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiplomaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EntityTypeController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HabilitationController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TempController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValueController;
use App\Http\Controllers\WorkController;
use App\Http\Middleware\CheckResponsibleProfile;
use Illuminate\Support\Facades\Route;

Route::middleware('check.auth')->group(function (){

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard0');
    Route::get('/dashboard0', [DashboardController::class, 'index'])->name('dashboard0');
    Route::get('/error', [DashboardController::class, 'error'])->name('error');

    /*
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    */

    Route::prefix('search')->group(function(){
        Route::get('/', [GlobalSearchController::class, 'index'])->name('global');
    });

    Route::prefix('cities')->group(function(){
        Route::get('/', [CityController::class, 'index'])->name('cities.index');
        Route::post('/store', [CityController::class, 'store'])->name('cities.store');
        Route::get('/download', [CityController::class, 'download'])->name('cities.download');
        Route::get('/{id}', [CityController::class, 'show'])->name('cities.show');
        Route::get('/show/{id}', [CityController::class, 'show'])->name('cities.show');
        Route::get('/edit/{id}', [CityController::class, 'edit'])->name('cities.edit');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('cities.update');
        Route::get('/delete/{id}', [CityController::class, 'delete'])->name('cities.delete');
    });

    Route::prefix('locals')->group(function(){
        Route::get('/', [LocalController::class, 'index'])->name('locals.index');
        Route::post('/store', [LocalController::class, 'store'])->name('locals.store');
        Route::get('/download', [LocalController::class, 'download'])->name('locals.download');
        Route::get('/{id}', [LocalController::class, 'show'])->name('locals.show');
        Route::post('/update/{id}', [LocalController::class, 'update'])->name('locals.update');
        Route::get('/delete/{id}', [LocalController::class, 'delete'])->name('locals.delete');
    });

    Route::prefix('affectations')->group(function(){
        Route::get('/', [AffectationController::class, 'index'])->name('affectations.index');
        Route::post('/store', [AffectationController::class, 'store'])->name('affectations.store');
        Route::get('/{id}', [AffectationController::class, 'show'])->name('affectations.show');
        Route::post('/import/section', [AffectationController::class, 'import_section'])->name('affectations.sections.import');
        Route::post('/import/sector', [AffectationController::class, 'import_sector'])->name('affectations.sectors.import');
        Route::post('/import/entity', [AffectationController::class, 'import_entity'])->name('affectations.entities.import');
        Route::post('/import/service', [AffectationController::class, 'import_service'])->name('affectations.services.import');
        Route::post('/update/{id}', [AffectationController::class, 'update'])->name('affectations.update');
        Route::get('/delete/{id}', [AffectationController::class, 'delete'])->name('affectations.delete');
        Route::get('/edit/{employee_id}/{affectation_id}', [AffectationController::class, 'edit'])->name('affectations.edit');
    });

    Route::prefix('services')->group(function(){
        Route::get('/', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/store', [ServiceController::class, 'store'])->name('services.store');
        Route::post('/import', [ServiceController::class, 'import'])->name('services.import');
        Route::post('/search', [ServiceController::class, 'search'])->name('services.search');
        Route::get('/download', [ServiceController::class, 'download'])->name('services.download');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('services.update');
        Route::get('/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
    });

    Route::prefix('entities')->group(function(){
        Route::get('/', [EntityController::class, 'index'])->name('entities.index');
        Route::get('/create', [EntityController::class, 'create'])->name('entities.create');
        Route::post('/store', [EntityController::class, 'store'])->name('entities.store');
        Route::post('/import', [EntityController::class, 'import'])->name('entities.import');
        Route::post('/search', [EntityController::class, 'search'])->name('entities.search');
        Route::get('/download', [EntityController::class, 'download'])->name('entities.download');
        Route::get('/{id}', [EntityController::class, 'show'])->name('entities.show');
        Route::get('/edit/{id}', [EntityController::class, 'edit'])->name('entities.edit');
        Route::post('/update/{id}', [EntityController::class, 'update'])->name('entities.update');
        Route::get('/delete/{id}', [EntityController::class, 'delete'])->name('entities.delete');
    });

    Route::prefix('sectors')->group(function(){
        Route::get('/', [SectorController::class, 'index'])->name('sectors.index');
        Route::get('/create', [SectorController::class, 'create'])->name('sectors.create');
        Route::post('/store', [SectorController::class, 'store'])->name('sectors.store');
        Route::post('/import', [SectorController::class, 'import'])->name('sectors.import');
        Route::get('/download', [SectorController::class, 'download'])->name('sectors.download');
        Route::get('/{id}', [SectorController::class, 'show'])->name('sectors.show');
        Route::get('/edit/{id}', [SectorController::class, 'edit'])->name('sectors.edit');
        Route::post('/update/{id}', [SectorController::class, 'update'])->name('sectors.update');
        Route::get('/delete/{id}', [SectorController::class, 'delete'])->name('sectors.delete');
    });

    Route::prefix('sections')->group(function(){
        Route::get('/', [SectionController::class, 'index'])->name('sections.index');
        Route::get('/create', [SectionController::class, 'create'])->name('sections.create');
        Route::post('/store', [SectionController::class, 'store'])->name('sections.store');
        Route::get('/download', [SectionController::class, 'download'])->name('sections.download');
        Route::get('/{id}', [SectionController::class, 'show'])->name('sections.show');
        Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('sections.edit');
        Route::post('/update/{id}', [SectionController::class, 'update'])->name('sections.update');
        Route::get('/delete/{id}', [SectionController::class, 'delete'])->name('sections.delete');
    });

    Route::prefix('occupations')->group(function(){
        Route::get('/', [OccupationController::class, 'index'])->name('occupations.index');
        Route::get('/create', [OccupationController::class, 'create'])->name('occupations.create');
        Route::post('/store', [OccupationController::class, 'store'])->name('occupations.store');
        Route::get('/download/{id?}', [OccupationController::class, 'download'])->name('occupations.download');
        Route::get('/{id}', [OccupationController::class, 'show'])->name('occupations.show');
        Route::get('/edit/{id}', [OccupationController::class, 'edit'])->name('occupations.edit');
        Route::post('/update/{id}', [OccupationController::class, 'update'])->name('occupations.update');
        Route::get('/delete/{id}', [OccupationController::class, 'delete'])->name('occupations.delete');
    });

    Route::prefix('grades')->group(function(){
        Route::get('/', [GradeController::class, 'index'])->name('grades.index');
        Route::get('/create', [GradeController::class, 'create'])->name('grades.create');
        Route::post('/store', [GradeController::class, 'store'])->name('grades.store');
        Route::get('/download/{id?}', [GradeController::class, 'download'])->name('grades.download');
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
        Route::get('/status', [EmployeeController::class, 'status'])->name('employees.status');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/search', [EmployeeController::class, 'search'])->name('employees.search');
        Route::get('/import', [EmployeeController::class, 'import'])->name('employees.import');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::post('/sort', [EmployeeController::class, 'sort'])->name('employees.sort');
        Route::get('/download/all', [EmployeeController::class, 'download'])->name('employees.download');
        Route::post('/import/all', [EmployeeController::class, 'import_all'])->name('employees.import.all');
        Route::get('/advance/search', [EmployeeController::class, 'advance'])->name('employees.advance');
        Route::get('/advance/result', [EmployeeController::class, 'result'])->name('employees.advance.result');
        Route::post('/importation', [EmployeeController::class, 'importation'])->name('employees.importation');
        Route::get('/history/{id}', [EmployeeController::class, 'history'])->name('employees.history');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::post('/change/state/{id}', [EmployeeController::class, 'state'])->name('employees.change.state');
        Route::get('/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');
        Route::get('/unities/{id}', [EmployeeController::class, 'unities'])->name('employees.unities');
        Route::get('/work/certificate/{id}', [EmployeeController::class, 'work_certificate'])->name('employees.work.certificate');
        Route::get('/bonus/certificate/{id}', [EmployeeController::class, 'bonus_certificate'])->name('employees.bonus.certificate');
        Route::get('/holiday/certificate/{id}', [EmployeeController::class, 'holiday_certificate'])->name('employees.holiday.certificate');
        Route::get('/renewal/certificate/{id}', [EmployeeController::class, 'renewal_certificate'])->name('employees.renewal.certificate');
        Route::post('/import/all/execute', [EmployeeController::class, 'import_execute'])->name('employees.import.all.execute');
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
        Route::get('/download/{id?}', [DiplomaController::class, 'download'])->name('diplomas.download');
        Route::get('/{id}', [DiplomaController::class, 'show'])->name('diplomas.show');
        Route::post('/store', [DiplomaController::class, 'store'])->name('diplomas.store');
        Route::get('/edit/{id}', [DiplomaController::class, 'edit'])->name('diplomas.edit');
        Route::post('/update/{id}', [DiplomaController::class, 'update'])->name('diplomas.update');
        Route::get('/delete/{id}', [DiplomaController::class, 'delete'])->name('diplomas.delete');
    });

    Route::prefix('options')->group(function(){
        Route::get('/', [OptionController::class, 'index'])->name('options.index');
        Route::get('/download/{id?}', [OptionController::class, 'download'])->name('options.download');
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
        Route::post('/update/{id}', [WorkController::class, 'update'])->name('works.update');
        Route::get('/delete/{id}', [WorkController::class, 'delete'])->name('works.delete');
        Route::post('/importation', [WorkController::class, 'importation'])->name('works.importation');
    });

    Route::prefix('qualifications')->group(function(){
        Route::get('/', [QualificationController::class, 'index'])->name('qualifications.index');
        Route::post('/store', [QualificationController::class, 'store'])->name('qualifications.store');
        Route::get('/{id}', [QualificationController::class, 'show'])->name('qualifications.show');
        Route::post('/update/{id}', [QualificationController::class, 'update'])->name('qualifications.update');
        Route::get('/delete/{id}', [QualificationController::class, 'delete'])->name('qualifications.delete');
        Route::post('/importation', [QualificationController::class, 'importation'])->name('qualifications.importation');
    });

    Route::prefix('competences')->group(function(){
        Route::get('/', [CompetenceController::class, 'index'])->name('competences.index');
        Route::post('/store', [CompetenceController::class, 'store'])->name('competences.store');
        Route::get('/{id}', [CompetenceController::class, 'show'])->name('competences.show');
        Route::post('/update/{id}', [CompetenceController::class, 'update'])->name('competences.update');
        Route::get('/delete/{id}', [CompetenceController::class, 'delete'])->name('competences.delete');
        Route::post('/importation', [CompetenceController::class, 'importation'])->name('competences.importation');
    });

    Route::prefix('chefs')->group(function(){
        Route::get('/', [ChefController::class, 'index'])->name('chefs.index');
        Route::post('/store', [ChefController::class, 'store'])->name('chefs.store');
        Route::get('/download', [ChefController::class, 'download'])->name('chefs.download');
        Route::get('/{id}', [ChefController::class, 'show'])->name('chefs.show');
        Route::get('/edit/{id}', [ChefController::class, 'edit'])->name('chefs.edit');
        Route::post('/update/{id}', [ChefController::class, 'update'])->name('chefs.update');
        Route::get('/delete/{id}', [ChefController::class, 'delete'])->name('chefs.delete');
    });

    Route::prefix('temps')->group(function(){
        Route::get('/', [TempController::class, 'index'])->name('temps.index');
        Route::post('/store', [TempController::class, 'store'])->name('temps.store');
        Route::get('/create', [TempController::class, 'create'])->name('temps.create');
        Route::get('/decision/{id}', [TempController::class, 'decision'])->name('temps.decision');
        Route::get('/{id}', [TempController::class, 'show'])->name('temps.show');
        Route::get('/edit/{id}', [TempController::class, 'edit'])->name('temps.edit');
        Route::post('/update/{id}', [TempController::class, 'update'])->name('temps.update');
        Route::get('/delete/{id}', [TempController::class, 'delete'])->name('temps.delete');
    });

    Route::prefix('trainings')->group(function(){
        Route::get('/', [TrainingController::class, 'index'])->name('trainings.index');
        Route::post('/store', [TrainingController::class, 'store'])->name('trainings.store');
        Route::get('/create', [TrainingController::class, 'create'])->name('trainings.create');
        Route::get('/download', [TrainingController::class, 'download'])->name('trainings.download');
        Route::get('/{id}', [TrainingController::class, 'show'])->name('trainings.show');
        Route::get('/edit/{id}', [TrainingController::class, 'edit'])->name('trainings.edit');
        Route::post('/update/{id}', [TrainingController::class, 'update'])->name('trainings.update');
        Route::get('/delete/{id}', [TrainingController::class, 'delete'])->name('trainings.delete');
        Route::get('/attendences/{id}', [TrainingController::class, 'attendences'])->name('trainings.attendences');
    });

    Route::prefix('attendences')->group(function(){
        Route::get('/', [AttendenceController::class, 'index'])->name('attendences.index');
        Route::post('/store/{id}', [AttendenceController::class, 'store'])->name('attendences.store');
        Route::get('/delete/{id}', [AttendenceController::class, 'delete'])->name('attendences.delete');
    });

    Route::prefix('configs')->group(function(){
        Route::get('/', [ConfigController::class, 'index'])->name('configs.index');
        Route::post('/store', [ConfigController::class, 'store'])->name('configs.store');
        Route::get('/create', [ConfigController::class, 'create'])->name('configs.create');
        Route::get('/decision/{id}', [ConfigController::class, 'decision'])->name('configs.decision');
        Route::get('/{id}', [ConfigController::class, 'show'])->name('configs.show');
        Route::get('/edit/{id}', [ConfigController::class, 'edit'])->name('configs.edit');
        Route::post('/update/{id}', [ConfigController::class, 'update'])->name('configs.update');
        Route::get('/delete/{id}', [ConfigController::class, 'delete'])->name('configs.delete');
    });

    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/store', [RegisteredUserController::class, 'store'])->name('users.store');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
    });

    Route::prefix('profiles')->group(function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profiles.index');
        Route::post('/store', [ProfileController::class, 'store'])->name('profiles.store');
        Route::get('/create', [ProfileController::class, 'create'])->name('profiles.create');
        Route::get('/{id}', [ProfileController::class, 'show'])->name('profiles.show');
        Route::get('/edit/{id}', [ProfileController::class, 'edit'])->name('profiles.edit');
        Route::post('/update/{id}', [ProfileController::class, 'update'])->name('profiles.update');
        Route::get('/delete/{id}', [ProfileController::class, 'delete'])->name('profiles.delete');
    });

    Route::prefix('rules')->group(function(){
        Route::get('/', [RuleController::class, 'index'])->name('rules.index');
        Route::post('/store', [RuleController::class, 'store'])->name('rules.store');
        Route::get('/create', [RuleController::class, 'create'])->name('rules.create');
        Route::get('/{id}', [RuleController::class, 'show'])->name('rules.show');
        Route::get('/edit/{id}', [RuleController::class, 'edit'])->name('rules.edit');
        Route::post('/update/{id}', [RuleController::class, 'update'])->name('rules.update');
        Route::get('/delete/{id}', [RuleController::class, 'delete'])->name('rules.delete');
    });

    Route::prefix('habilitations')->group(function(){
        Route::get('/', [HabilitationController::class, 'index'])->name('habilitations.index');
        Route::post('/store', [HabilitationController::class, 'store'])->name('habilitations.store');
        Route::get('/create', [HabilitationController::class, 'create'])->name('habilitations.create');
        Route::get('/{id}', [HabilitationController::class, 'show'])->name('habilitations.show');
        Route::get('/edit/{id}', [HabilitationController::class, 'edit'])->name('habilitations.edit');
        Route::post('/update/{id}', [HabilitationController::class, 'update'])->name('habilitations.update');
        Route::get('/delete/{id}', [HabilitationController::class, 'delete'])->name('habilitations.delete');
    });

    Route::prefix('audit/tables')->group(function(){
        Route::get('/', [TableController::class, 'index'])->name('audit.tables.index')->middleware(CheckResponsibleProfile::class);
        Route::post('/store', [TableController::class, 'store'])->name('audit.tables.store')->middleware(CheckResponsibleProfile::class);
        Route::get('/create', [TableController::class, 'create'])->name('audit.tables.create')->middleware(CheckResponsibleProfile::class);
        Route::post('/import', [TableController::class, 'import'])->name('audit.tables.import')->middleware(CheckResponsibleProfile::class);
        Route::get('/{id}', [TableController::class, 'show'])->name('audit.tables.show')->middleware(CheckResponsibleProfile::class);
        Route::get('/edit/{id}', [TableController::class, 'edit'])->name('audit.tables.edit')->middleware(CheckResponsibleProfile::class);
        Route::post('/update/{id}', [TableController::class, 'update'])->name('audit.tables.update')->middleware(CheckResponsibleProfile::class);
        Route::get('/delete/{id}', [TableController::class, 'delete'])->name('audit.tables.delete')->middleware(CheckResponsibleProfile::class);
    })->middleware(CheckResponsibleProfile::class);

    Route::prefix('audit/columns')->group(function(){
        Route::get('/', [ColumnController::class, 'index'])->name('audit.columns.index')->middleware(CheckResponsibleProfile::class);
        Route::post('/store', [ColumnController::class, 'store'])->name('audit.columns.store')->middleware(CheckResponsibleProfile::class);
        Route::get('/create', [ColumnController::class, 'create'])->name('audit.columns.create')->middleware(CheckResponsibleProfile::class);
        Route::get('/{id}', [ColumnController::class, 'show'])->name('audit.columns.show')->middleware(CheckResponsibleProfile::class);
        Route::get('/edit/{id}', [ColumnController::class, 'edit'])->name('audit.columns.edit')->middleware(CheckResponsibleProfile::class);
        Route::post('/update/{id}', [ColumnController::class, 'update'])->name('audit.columns.update')->middleware(CheckResponsibleProfile::class);
        Route::get('/delete/{id}', [ColumnController::class, 'delete'])->name('audit.columns.delete')->middleware(CheckResponsibleProfile::class);
    });

    Route::prefix('audit/periods')->group(function(){
        Route::get('/', [PeriodController::class, 'index'])->name('audit.periods.index')->middleware(CheckResponsibleProfile::class);
        Route::post('/store', [PeriodController::class, 'store'])->name('audit.periods.store')->middleware(CheckResponsibleProfile::class);
        Route::get('/create', [PeriodController::class, 'create'])->name('audit.periods.create')->middleware(CheckResponsibleProfile::class);
        Route::get('/{id}', [PeriodController::class, 'show'])->name('audit.periods.show')->middleware(CheckResponsibleProfile::class);
        Route::get('/edit/{id}', [PeriodController::class, 'edit'])->name('audit.periods.edit')->middleware(CheckResponsibleProfile::class);
        Route::post('/update/{id}', [PeriodController::class, 'update'])->name('audit.periods.update')->middleware(CheckResponsibleProfile::class);
        Route::get('/delete/{id}', [PeriodController::class, 'delete'])->name('audit.periods.delete')->middleware(CheckResponsibleProfile::class);
    });

    Route::prefix('audit/relations')->group(function(){
        Route::get('/', [RelationController::class, 'index'])->name('audit.relations.index')->middleware(CheckResponsibleProfile::class);
        Route::post('/store', [RelationController::class, 'store'])->name('audit.relations.store')->middleware(CheckResponsibleProfile::class);
        Route::get('/create', [RelationController::class, 'create'])->name('audit.relations.create')->middleware(CheckResponsibleProfile::class);
        Route::get('/{id}', [RelationController::class, 'show'])->name('audit.relations.show')->middleware(CheckResponsibleProfile::class);
        Route::get('/edit/{id}', [RelationController::class, 'edit'])->name('audit.relations.edit')->middleware(CheckResponsibleProfile::class);
        Route::post('/update/{id}', [RelationController::class, 'update'])->name('audit.relations.update')->middleware(CheckResponsibleProfile::class);
        Route::get('/delete/{id}', [RelationController::class, 'delete'])->name('audit.relations.delete')->middleware(CheckResponsibleProfile::class);
    });

    Route::prefix('audit/values')->group(function(){
        Route::get('/', [ValueController::class, 'index'])->name('audit.values.index')->middleware(CheckResponsibleProfile::class);
        Route::get('/consult', [ValueController::class, 'consult'])->name('audit.values.consult')->middleware(CheckResponsibleProfile::class);
        Route::get('/select', [ValueController::class, 'select'])->name('audit.values.select')->middleware(CheckResponsibleProfile::class);
        Route::get('/view/{emp}', [ValueController::class, 'view'])->name('audit.values.view')->middleware(CheckResponsibleProfile::class);
        Route::get('/view-2/{emp}', [ValueController::class, 'view_2'])->name('audit.values.view.2')->middleware(CheckResponsibleProfile::class);
        Route::get('/view/{entityName}/{id}', [ValueController::class, 'view_entity'])->name('audit.values.view.entity')->middleware(CheckResponsibleProfile::class);
        Route::get('/view/{entityName}/{id}/details/{table_id}', [ValueController::class, 'view_entity_details'])->name('audit.values.view.entity.details')->middleware(CheckResponsibleProfile::class);
        Route::post('/store', [ValueController::class, 'store'])->name('audit.values.store')->middleware(CheckResponsibleProfile::class);
        Route::post('/import', [ValueController::class, 'import'])->name('audit.values.import')->middleware(CheckResponsibleProfile::class);
        Route::get('/create', [ValueController::class, 'create'])->name('audit.values.create')->middleware(CheckResponsibleProfile::class);
        Route::get('/{id}', [ValueController::class, 'show'])->name('audit.values.show')->middleware(CheckResponsibleProfile::class);
        Route::get('/edit/{id}/{attr}', [ValueController::class, 'edit'])->name('audit.values.edit')->middleware(CheckResponsibleProfile::class);
        Route::post('/update', [ValueController::class, 'update'])->name('audit.values.update')->middleware(CheckResponsibleProfile::class);
        Route::get('/delete/{attr}', [ValueController::class, 'delete'])->name('audit.values.delete')->middleware(CheckResponsibleProfile::class);
        Route::get('/download/model/{tbl?}/{srv?}/{ent?}/{sectr?}/{sect?}', [ValueController::class, 'download_model'])->name('audit.values.download.model')->middleware(CheckResponsibleProfile::class);
    });

    /*
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    */
});

require __DIR__.'/auth.php';
