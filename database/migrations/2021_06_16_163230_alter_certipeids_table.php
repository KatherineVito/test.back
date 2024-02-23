<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCertipeidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certipeids', function (Blueprint $table) {
            $table->string('country_code',45)->change();
            $table->string('cellphone_owner',20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certipeids', function (Blueprint $table) {
            $table->string('country_code',45)->change();
            $table->string('cellphone_owner',20)->change();
        });
    }
}
