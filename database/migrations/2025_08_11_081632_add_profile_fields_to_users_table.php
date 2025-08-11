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
            $table->unsignedBigInteger('kementerian_id')->nullable()->after('profile_picture');
            $table->unsignedBigInteger('agensi_id')->nullable()->after('kementerian_id');
            $table->unsignedBigInteger('sub_agensi_id')->nullable()->after('agensi_id');
            $table->string('no_pejabat', 50)->nullable()->after('sub_agensi_id');
            $table->string('no_hp', 50)->nullable()->after('no_pejabat');
            $table->string('no_fax', 50)->nullable()->after('no_hp');
            $table->text('alamat_pejabat')->nullable()->after('no_fax');
            $table->string('poskod', 10)->nullable()->after('alamat_pejabat');
            $table->string('negeri', 50)->nullable()->after('poskod');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'kementerian_id', 'agensi_id', 'sub_agensi_id', 
                'no_pejabat', 'no_hp', 'no_fax', 
                'alamat_pejabat', 'poskod', 'negeri'
            ]);
        });
    }
};
