<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_requests', function (Blueprint $table) {
            $table->increments('requestID');
            $table->integer('clientID');
            $table->string('requisitioningUnit');
            $table->string('location');
            $table->integer('serviceID');
            $table->string('description');
            $table->date('dateNeeded');
            $table->date('alternativeDate');
            $table->string('contactNo');
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
        Schema::dropIfExists('job_requests');
    }
}
