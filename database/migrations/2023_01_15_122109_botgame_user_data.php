<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BotgameUserData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('message_last')->nullable()->comment("Посл сообщение");
            $table->string('message_from')->nullable()->comment("Откуда сообщение. vk, tg, local");
            $table->string('vk_id')->nullable();
            $table->string('tg_id')->nullable();
            $table->integer('last_message_time')->nullable()->default(0);
        });

        Schema::create('histories', function(Blueprint $table) {
            $table->id();
            $table->boolean('isFromBot')->default(0)->comment("это сообщение от бота");
            $table->integer('user_id')->default(0)->comment("с кем диалог");
            $table->integer('money')->default(0)->comment("Баланс игрока на момент сообщения");
            $table->text('message')->nullable()->comment("Сообщение которое написал пользователь");
            $table->text('message_response')->nullable()->comment("Текст которым ответил бот");
            $table->json('buttons')->nullable()->comment("Дата с кнопками");
            $table->string('attachment')->nullable()->comment("Атач");
            $table->string('attachment_sound')->nullable()->comment("Атач звука");
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

        Schema::dropIfExists('histories');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['message_last','message_from','vk_id','tg_id',]);
        });
    }
}
