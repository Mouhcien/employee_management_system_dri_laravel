<?php

use App\Models\Employee;
use App\Models\Grade;
use App\Models\Level;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Level::class, 'level_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Grade::class, 'grade_id')->constrained()->cascadeOnDelete();
            $table->date('starting_date')->nullable();
            $table->date('finished_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competences');
    }
};
