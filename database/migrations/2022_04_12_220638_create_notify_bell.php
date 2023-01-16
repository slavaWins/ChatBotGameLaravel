<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyBell extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notyfy', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->string('route')->nullable();
            $table->bigInteger('uid')->nullable();
            $table->boolean('isOpen')->default(false);

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
        Schema::dropIfExists('notyfy');
    }
}
