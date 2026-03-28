<?php

use App\Models\Employee;
use App\Models\Period;
use App\Models\Relation;
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
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Relation::class, 'relation_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Period::class, 'period_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Employee::class, 'employee_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('values');
    }
};
