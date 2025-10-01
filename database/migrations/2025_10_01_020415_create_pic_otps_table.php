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
        Schema::create('pic_otps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_in_charge_id');
            $table->string('otp_hash'); // Hashed OTP
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();

            $table->foreign('person_in_charge_id')->references('id')->on('person_in_charge')->onDelete('cascade');
            $table->index(['person_in_charge_id', 'is_used', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pic_otps');
    }
};
