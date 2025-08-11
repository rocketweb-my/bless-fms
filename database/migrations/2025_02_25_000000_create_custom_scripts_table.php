<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('custom_scripts')) {
            Schema::create('custom_scripts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description');
                $table->enum('location', ['head', 'body'])->default('head');
                $table->enum('page', ['feedback_form', 'all_pages'])->default('all_pages');
                $table->longText('script_content');
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_scripts');
    }
}
