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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kumpulan_pengguna_id')->nullable()->after('profile_picture');
            $table->foreign('kumpulan_pengguna_id')->references('id')->on('lookup_kumpulan_pengguna')->onDelete('set null');
            $table->index('kumpulan_pengguna_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kumpulan_pengguna_id']);
            $table->dropIndex(['kumpulan_pengguna_id']);
            $table->dropColumn('kumpulan_pengguna_id');
        });
    }
};
