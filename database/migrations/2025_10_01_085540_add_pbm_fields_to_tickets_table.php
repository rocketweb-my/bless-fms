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
            $table->string('kategori_aduan')->nullable()->after('bl_no')->comment('Category name from dropdown');
            $table->string('nombor_serahan')->nullable()->after('kategori_aduan');
            $table->string('jenis_permohonan')->nullable()->after('nombor_serahan');
            $table->unsignedBigInteger('kementerian_id')->nullable()->after('jenis_permohonan');

            // Add foreign key if needed
            $table->foreign('kementerian_id')->references('id')->on('lookup_kementerian')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['kementerian_id']);
            $table->dropColumn(['kategori_aduan', 'nombor_serahan', 'jenis_permohonan', 'kementerian_id']);
        });
    }
};
