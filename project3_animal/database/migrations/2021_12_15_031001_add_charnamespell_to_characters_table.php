<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCharnamespellToCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            //
            //如果想要新增舊有資料表的欄位的話，使用新的migration檔案比較好
            //角色名字念法
            $table->string("char_name_spell");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            //
            //這編寫這個migration檔案要卸除的時候要做的事，就是把那個欄位拿掉
            $table->dropColumn("char_name_spell");
        });
    }
}
