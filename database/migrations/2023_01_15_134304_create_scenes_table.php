<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenes', function (Blueprint $table) {
            $table->id();
            $table->string('className')->index()->nullable()->index();
            $table->json('sceneData');
            $table->integer('user_id')->default(0)->nullable()->index();
            $table->bigInteger('timer_to')->default(0)->nullable()->index();
            $table->bigInteger('timer_from')->default(0)->nullable();
            $table->integer('step')->default(0)->nullable();
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
        Schema::dropIfExists('scenes');
    }
}
