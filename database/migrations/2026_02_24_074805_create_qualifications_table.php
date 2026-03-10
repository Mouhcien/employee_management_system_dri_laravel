<?php

use App\Models\Diploma;
use App\Models\Employee;
use App\Models\Option;
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
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'employee_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Diploma::class, 'diploma_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Option::class, 'option_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('year')->nullable(); //date d'obtention
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};
