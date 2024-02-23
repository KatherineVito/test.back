<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->integer('dni_number_pet');
            $table->date('date_enrollment_pet',255);
            $table->string('lastname_pet',100);
            $table->string('name_pet',100);
            $table->string('lastname_owner',255);
            $table->string('name_owner',255);
            $table->string('cellphone_owner',14);
            $table->string('email_owner',100);
            $table->string('ip_extra_information',100);
            $table->string('country_code_extra_information', 10);
            $table->string('country_name_extra_information', 255);
            $table->string('region_department_or_state_extra_information', 255);
            $table->string('province_extra_information', 255);
            $table->string('district_extra_information', 255);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
