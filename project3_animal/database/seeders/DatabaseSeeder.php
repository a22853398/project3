<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//要引用的東西們
use App\Models\character;
use App\Models\User;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //取消約束外鍵
        Schema::disableForeignKeyConstraints();
        character::truncate();//清空資料表，ID歸0
        User::truncate();//清空user資料表 ID歸0

        //建立五筆會員測試資料
        User::factory(5)->create();
        //建立一萬筆角色測試資料
        character::factory(1000)->create();
        //開啟外鍵約束
        Schema::enableForeignKeyConstraints();

    }
}
