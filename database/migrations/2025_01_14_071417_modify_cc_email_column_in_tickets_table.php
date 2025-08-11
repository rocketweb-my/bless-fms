<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCcEmailColumnInTicketsTable extends Migration
{

    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('cc_email')->nullable()->change();
        });
    }


    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('cc_email')->change(); // Changing back to varchar
        });
    }
}
