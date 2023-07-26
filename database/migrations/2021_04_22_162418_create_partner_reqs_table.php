<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_reqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('company_description')->nullable();
            $table->string('company_address');
            $table->string('company_contact');
            $table->string('registration_number');
            $table->string('company_email');
            $table->string('status');
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
        Schema::dropIfExists('partner_reqs');
    }
}
