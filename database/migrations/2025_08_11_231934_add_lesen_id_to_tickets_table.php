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
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('lesen_id')->nullable()->after('sub_agensi_id');
            $table->foreign('lesen_id')->references('id')->on('lookup_lesen')->onDelete('set null');
            $table->index('lesen_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['lesen_id']);
            $table->dropIndex(['lesen_id']);
            $table->dropColumn('lesen_id');
        });
    }
};
