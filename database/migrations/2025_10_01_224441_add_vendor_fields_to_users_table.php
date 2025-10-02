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
            // Add user_type to differentiate between staff and vendors
            $table->enum('user_type', ['staff', 'vendor'])->default('staff')->after('isadmin')->comment('Type of user: staff or vendor');

            // Add vendor_type for vendors (admin or technical)
            $table->enum('vendor_type', ['admin', 'technical'])->nullable()->after('user_type')->comment('Vendor type: admin or technical');

            // Add company name for vendors
            $table->string('company')->nullable()->after('name')->comment('Company name for vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'vendor_type', 'company']);
        });
    }
};
