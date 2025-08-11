<?php

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
        Schema::create('lookup_priority', function (Blueprint $table) {
            $table->id();
            $table->integer('priority_value')->unique(); // 1=High, 2=Medium, 3=Low
            $table->string('name_en');
            $table->string('name_ms');
            $table->integer('duration_days')->default(3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lookup_priority');
    }
};
