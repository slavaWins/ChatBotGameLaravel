<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableSukasModify extends Migration
{

    public function up()
    {
        Schema::table('sukas', function(Blueprint $table) {

            $table->integer("user_id")->nullable()->comment("Поле пользователя") ;
            $table->string("message")->nullable()->comment("Поле с описание типа") ;
        });
    }

    public function down()
    {
        Schema::table('sukas', function (Blueprint $table) {
            $table->dropColumn([
            'user_id',
            'message',
            ]);
        });
    }
}
