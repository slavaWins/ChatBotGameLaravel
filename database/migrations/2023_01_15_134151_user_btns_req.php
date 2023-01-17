<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserBtnsReq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('buttons')->nullable()->comment("Дата с кнопками");
           // $table->integer('scene_id')->nullable()->comment("Ид сцены");

            $table->boolean('is_registration_end')->default(false)->comment("Прошел ли игрок регистрацию");

            $table->integer('tutorial_step')->comment("Текущий шаг туториала")->nullable();
            $table->string('tutorial_class')->comment("Класс туториала")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['buttons', 'scene_id']);
        });
    }
}
