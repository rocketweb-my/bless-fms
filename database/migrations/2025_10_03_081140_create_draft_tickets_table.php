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
        Schema::create('draft_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('trackid')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('subject')->nullable();
            $table->longText('message')->nullable();
            $table->integer('priority')->nullable();
            $table->string('status')->default('draft');
            $table->integer('category')->nullable();
            $table->integer('sub_category')->nullable();
            $table->integer('owner')->nullable();
            $table->text('attachments')->nullable();
            $table->longText('history')->nullable();
            $table->string('ip')->nullable();
            $table->string('language')->nullable();
            $table->string('articles')->nullable();
            $table->string('merged')->nullable();
            $table->dateTime('dt')->nullable();
            $table->dateTime('lastchange')->nullable();
            $table->integer('openby')->nullable();

            // Custom fields (1-50)
            $table->text('custom1')->nullable();
            $table->text('custom2')->nullable();
            $table->text('custom3')->nullable();
            $table->text('custom4')->nullable();
            $table->text('custom5')->nullable();
            $table->text('custom6')->nullable();
            $table->text('custom7')->nullable();
            $table->text('custom8')->nullable();
            $table->text('custom9')->nullable();
            $table->text('custom10')->nullable();
            $table->text('custom11')->nullable();
            $table->text('custom12')->nullable();
            $table->text('custom13')->nullable();
            $table->text('custom14')->nullable();
            $table->text('custom15')->nullable();
            $table->text('custom16')->nullable();
            $table->text('custom17')->nullable();
            $table->text('custom18')->nullable();
            $table->text('custom19')->nullable();
            $table->text('custom20')->nullable();
            $table->text('custom21')->nullable();
            $table->text('custom22')->nullable();
            $table->text('custom23')->nullable();
            $table->text('custom24')->nullable();
            $table->text('custom25')->nullable();
            $table->text('custom26')->nullable();
            $table->text('custom27')->nullable();
            $table->text('custom28')->nullable();
            $table->text('custom29')->nullable();
            $table->text('custom30')->nullable();
            $table->text('custom31')->nullable();
            $table->text('custom32')->nullable();
            $table->text('custom33')->nullable();
            $table->text('custom34')->nullable();
            $table->text('custom35')->nullable();
            $table->text('custom36')->nullable();
            $table->text('custom37')->nullable();
            $table->text('custom38')->nullable();
            $table->text('custom39')->nullable();
            $table->text('custom40')->nullable();
            $table->text('custom41')->nullable();
            $table->text('custom42')->nullable();
            $table->text('custom43')->nullable();
            $table->text('custom44')->nullable();
            $table->text('custom45')->nullable();
            $table->text('custom46')->nullable();
            $table->text('custom47')->nullable();
            $table->text('custom48')->nullable();
            $table->text('custom49')->nullable();
            $table->text('custom50')->nullable();

            // Additional fields from admin form
            $table->foreignId('kaedah_melapor_id')->nullable()->constrained('lookup_kaedah_melapor')->onDelete('set null');
            $table->date('tarikh_aduan')->nullable();
            $table->time('masa_aduan')->nullable();
            $table->string('jantina')->nullable();
            $table->string('login_id')->nullable();
            $table->string('complaint_type')->nullable();
            $table->string('aduan_pertanyaan')->nullable();
            $table->foreignId('agensi_id_umum')->nullable()->constrained('lookup_agensi')->onDelete('set null');
            $table->foreignId('agensi_id_teknikal')->nullable()->constrained('lookup_agensi')->onDelete('set null');
            $table->string('pertanyaan')->nullable();
            $table->foreignId('lesen_id_umum')->nullable()->constrained('lookup_lesen')->onDelete('set null');
            $table->foreignId('lesen_id_teknikal')->nullable()->constrained('lookup_lesen')->onDelete('set null');
            $table->string('jenis_permohonan_umum')->nullable();
            $table->string('jenis_permohonan_teknikal')->nullable();
            $table->string('nombor_serahan_umum')->nullable();
            $table->string('nombor_serahan_teknikal')->nullable();
            $table->integer('kategori_aplikasi')->nullable();
            $table->integer('kategori_server')->nullable();
            $table->integer('assignment_kumpulan_pengguna_id')->nullable();
            $table->boolean('notify')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_tickets');
    }
};
