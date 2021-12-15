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
            //自動產生ID
            $table->id();
            //自訂序號
            $table->string("serialid");
            //名字
            $table->string("char_name");
            //性別
            $table->string("gender");
            //身高
            $table->tinyInteger("char_height");
            //體重
            $table->tinyInteger("char_weight");
            //生日
            $table->date("birthday");
            //部活
            $table->string("club");
            //個性及說明
            $table->text("description")->nullable();
            //契約能力、戰鬥style等
            $table->text("battle_relate")->nullable();

            //時間戳記
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
        Schema::dropIfExists('characters');
    }
}
