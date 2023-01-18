<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasyAnaliticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_analitics', function (Blueprint $table) {
            $table->id();
            $table->string("ind")->nullable()->comment("Индификатор статистики");
            $table->string("date_day")->nullable()->comment("Денормализация для быстрого поиска по дате");
            $table->integer("amount")->default(0);
            $table->timestamps();
        });

        Schema::create('easy_analitics_settings', function (Blueprint $table) {
            $table->id();
            $table->string("ind")->nullable();
            $table->string("name")->nullable()->default("Example name")->comment("Человеское название для аналитики");
            $table->string("descr")->nullable()->default("Example descr")->comment("Описание");
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
        Schema::dropIfExists('easy_analitics');
        Schema::dropIfExists('easy_analitics_settings');
    }
}
