<?php

use App\Models\Period;
use App\Models\PlantVariety;
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
        Schema::create('tresholds', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->nullable();
            $table->foreignIdFor(PlantVariety::class);
            $table->foreignIdFor(Period::class);
            $table->string('name')->nullable();
            $table->float('natrium_min')->default(0);
            $table->float('natrium_max')->default(0);
            $table->float('kalium_min')->default(0);
            $table->float('kalium_max')->default(0);
            $table->float('ph_min')->default(0);
            $table->float('ph_max')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tresholds');
    }
};
