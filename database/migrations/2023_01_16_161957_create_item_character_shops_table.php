<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCharacterShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_character_shops', function (Blueprint $table) {
            $table->id();
            $table->json('characterData');
            $table->integer('price')->comment("Стоимость товара. Иногда может сама считать и игнорить редактор")->default(0);
            $table->integer('buy_count')->comment("Колв покупок товара")->default(0);
            $table->string('className')->comment("Название класса для каста")->nullable()->index();
            $table->string('name')->comment("Название итема, уйдет в чараектера потом")->default("Toyto Prius 2004");
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
        Schema::dropIfExists('item_character_shops');
    }
}
