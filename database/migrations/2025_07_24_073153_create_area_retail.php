<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('area_retail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retail_id')->constrained('retails');
            $table->foreignId('area_id')->constrained('areas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('area_retail');
    }
};
