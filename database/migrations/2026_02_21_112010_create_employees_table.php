<?php

use App\Models\Chef;
use App\Models\Classement;
use App\Models\Competence;
use App\Models\Gender;
use App\Models\Local;
use App\Models\Qualification;
use App\Models\Remuneration;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('firstname_arab')->nullable();
            $table->string('lastname_arab')->nullable();
            $table->string('gender')->nullable();
            $table->date('hiring_date')->nullable();
            $table->foreignIdFor(Local::class, 'local_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Qualification::class, 'qualification_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Competence::class, 'competence_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Classement::class, 'classement_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Remuneration::class, 'remuneration_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
