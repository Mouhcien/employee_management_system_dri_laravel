<?php

use App\Models\Affectation;
use App\Models\Demand;
use App\Models\Employee;
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
        Schema::create('mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Affectation::class, 'from_affectation_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Affectation::class, 'to_affectation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->char('category_name')->default('N'); //D: demande N: necissité de service
            $table->string('ref')->nullable(); // reference de demande
            $table->date('starting_date')->nullable();
            $table->string('entity_name')->nullable();
            $table->string('direction_name')->nullable();
            $table->string('city_name')->nullable();
            $table->char('type')->default('I'); // I:Interne E:Externe
            $table->foreignIdFor(Demand::class, 'demand_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutations');
    }
};
