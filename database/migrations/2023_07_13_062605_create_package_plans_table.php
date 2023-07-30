<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('package_name')->nullable();
            $table->string('invoice')->nullable();

            $table->string('package_credits')->nullable();
            $table->string('package_amount')->nullable();
           
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
        Schema::dropIfExists('package_plans');
    }
};
