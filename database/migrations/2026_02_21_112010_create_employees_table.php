<?php

use App\Models\Chef;
use App\Models\Classement;
use App\Models\Competence;
use App\Models\Gender;
use App\Models\Local;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\Remuneration;
use App\Models\Work;
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
            $table->string('ppr');
            $table->string('cin');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('firstname_arab')->nullable();
            $table->string('lastname_arab')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('gender', ['M', 'F'])->nullable();
            $table->string('sit', ['C', 'D', 'M'])->nullable();
            $table->date('hiring_date')->nullable();
            $table->foreignIdFor(Work::class, 'work_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Local::class, 'local_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Qualification::class, 'qualification_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Competence::class, 'competence_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Classement::class, 'classement_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Remuneration::class, 'remuneration_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('disposition_date')->nullable();
            $table->string('disposition_reason')->nullable();
            $table->date('retiring_date')->nullable();
            $table->date('reintegration_date')->nullable();
            $table->string('reintegration_reason')->nullable();
            $table->string('commission_card')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->nullable();
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
