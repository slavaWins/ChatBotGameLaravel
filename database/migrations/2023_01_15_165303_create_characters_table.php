<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('className')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->json('characterData');
            $table->timestamps();
        });


        Schema::table('users', function (Blueprint $table) {
            $table->integer('player_id')->nullable()->comment("Ид чара игрока");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['player_id']);
        });
    }
}
