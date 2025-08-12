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
        // Check if agensi_id column already exists
        if (!Schema::hasColumn('lookup_lesen', 'agensi_id')) {
            Schema::table('lookup_lesen', function (Blueprint $table) {
                $table->unsignedBigInteger('agensi_id')->after('id');
            });
        }
        
        // Clear existing data since we're changing the relationship structure
        \DB::table('lookup_lesen')->delete();
        
        // Add foreign key constraint if it doesn't exist
        Schema::table('lookup_lesen', function (Blueprint $table) {
            // Check and drop foreign key for kementerian_id if it exists
            $foreignKeys = \DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE table_name = 'hesk_lookup_lesen' AND COLUMN_NAME = 'kementerian_id' AND REFERENCED_TABLE_NAME IS NOT NULL");
            if (!empty($foreignKeys)) {
                $table->dropForeign(['kementerian_id']);
            }
            
            // Drop kementerian_id column if it exists
            if (Schema::hasColumn('lookup_lesen', 'kementerian_id')) {
                $table->dropColumn('kementerian_id');
            }
            
            // Add foreign key for agensi_id
            $table->foreign('agensi_id')->references('id')->on('lookup_agensi')->onDelete('cascade');
            $table->index('agensi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lookup_lesen', function (Blueprint $table) {
            // Drop the new foreign key constraint and column
            $table->dropForeign(['agensi_id']);
            $table->dropIndex(['agensi_id']);
            $table->dropColumn('agensi_id');
            
            // Add back the old kementerian_id column with foreign key
            $table->unsignedBigInteger('kementerian_id')->after('id');
            $table->foreign('kementerian_id')->references('id')->on('lookup_kementerian')->onDelete('cascade');
        });
    }
};
