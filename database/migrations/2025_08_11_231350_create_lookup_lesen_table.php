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
        Schema::create('lookup_lesen', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('penerangan')->nullable();
            $table->unsignedBigInteger('kementerian_id');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->foreign('kementerian_id')->references('id')->on('lookup_kementerian')->onDelete('cascade');
            $table->index(['kementerian_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lookup_lesen');
    }
};
