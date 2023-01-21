<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBotEditor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_rooms', function (Blueprint $table) {
            $table->id();
            $table->string("item_varible_name1")->nullable();
            $table->string("item_varible_class1")->nullable();
            $table->string("item_varible_name2")->nullable();
            $table->string("item_varible_class2")->nullable();
            $table->string("className")->nullable();
            $table->timestamps();
        });

        Schema::create('virtual_steps', function (Blueprint $table) {
            $table->id();
            $table->integer("step")->nullable()->default(0);
            $table->string("name")->nullable();
            $table->string("className")->nullable();
            $table->string("ind")->nullable();
            $table->string("start_message")->nullable();
            $table->string("selector_character")->nullable();
            $table->string("btn_next")->nullable();
            $table->string("btn_back")->nullable();
            $table->string("btn_exit")->nullable();
            $table->string("btn_scene_name")->nullable();
            $table->string("btn_scene_class")->nullable();
            $table->string("btn_shop_name")->nullable();
            $table->string("btn_shop_class")->nullable();

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
        Schema::dropIfExists('virtual_steps');
        Schema::dropIfExists('virtual_rooms');
    }
}
