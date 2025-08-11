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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('setting_email');
        Schema::create('setting_email', function (Blueprint $table) {
            $table->id();
            $table->enum('mail_method', ['mail', 'smtp'])->default('smtp');
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->integer('smtp_timeout')->default(25);
            $table->enum('ssl_protocol', ['on', 'off'])->default('off');
            $table->enum('tls_protocol', ['on', 'off'])->default('off');
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_from_email')->nullable();
            $table->string('smtp_from_name')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
