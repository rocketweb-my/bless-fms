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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 60);
            $table->smallInteger('category_id')->unsigned();
            $table->smallInteger('cat_order')->unsigned();
            $table->enum('autoassign', ['0', '1'])->default('0');
            $table->enum('type', ['0', '1'])->default('0');
            $table->enum('priority', ['0', '1', '2', '3'])->default('3');
            
            // Foreign key will be added separately if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
