<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccomplishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accomplish', function (Blueprint $table) {
            $table->integer('jobRequestID');
            $table->integer('serviceProviderID');
            $table->string('remarks')->length(1000);
            $table->integer('rating')->nullable();
            $table->boolean('confirm')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('accomplish');
    }
}
