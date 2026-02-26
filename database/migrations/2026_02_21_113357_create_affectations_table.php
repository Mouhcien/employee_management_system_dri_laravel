<?php

use App\Models\Employee;
use App\Models\Entity;
use App\Models\Section;
use App\Models\Sector;
use App\Models\Service;
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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->boolean('state')->default(true);
            $table->foreignIdFor(Service::class, 'service_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Entity::class, 'entity_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Sector::class, 'sector_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Section::class, 'section_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Employee::class, 'employee_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('affectation_date')->nullable();
            $table->date('finished_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
