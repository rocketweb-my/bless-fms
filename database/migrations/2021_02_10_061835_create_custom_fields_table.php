<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('custom_fields'))
        {

        }else{
            Schema::create('custom_fields', function (Blueprint $table) {
                $table->tinyInteger('id',false, true);
                $table->enum('use',['0','1','2'])->default('0');
                $table->enum('place',['0','1'])->default('0');
                $table->string('type',20)->default('text');
                $table->enum('req',['0','1','2'])->default('0');
                $table->text('category')->nullable();
                $table->text('name')->nullable();
                $table->text('value')->nullable();
                $table->smallInteger('order',false,true)->default('10');
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
        Schema::dropIfExists('custom_fields');
    }
}
