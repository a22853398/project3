<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//要亂數產生的API們
use App\Models\character;
use App\Models\User;
use Illuminate\Support\Str;

class CharacterFactory extends Factory
{
    protected $model = character::class;

    /**
     * 回傳一個名字陣列
     * @return (kanji, katagana, romaji)
     */
    protected function getCharNameArray($gender){
        $tmpArray = ($gender == "male") ? $this->faker->first_name_male_pair() : $this->faker->first_name_female_pair();
        return $tmpArray;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $array_serialid = array("FIRE01", "WATER01", "GRASS01", 
                                "NORMAL01", "FLY01", "FIGHT01", 
                                "EVIL01", "GHOST01", "TOXIC01",
                                "FULLMETAL01", "ROCK01", "EARTH01",
                                "FAIRY01", "BUG01", "PSYCHIC01",
                                "ELECTRIC01", "DRAGON01", "ICE01"
                            );
        $gender =  array_rand(array("male", "female"));
        $char_name = $this->getCharNameArray($gender);
        $club = array_rand(array("剣道", "弓道", "空手", "柔道", "相撲", "茶道", "文芸", "奉仕", 
                                "生徒会", "帰宅", "図書委員", "風紀委員", "保健委員", "野球", "サッカー",
                                "合気道", "オカルト", "アイドル研究", "昆虫研究", "チアリーディング",
                                "吹奏楽", "映像研究", "パソコン研究", "水泳", "水球", "陸上", "軽音楽",
                                "バレーボール", "バスケットボール", "社交ダンス", "漫画研究", "天文観測", "科学研究"
                            ));
        return [
            //使用faker 類別產生隨機機料

            //清單中隨機取一個分類的屬性
            "serialid" => array_rand($array_serialid),
            //隨機角色性別
            "gender" => $gender,
            //隨機角色名稱
            "char_name" => $char_name[0],
            //隨機角色念法
            "char_name_spell" => $char_name[1],
            //隨機身高
            "char_height" => random_int(140, 190),
            //隨機體重
            "char_weight" => random_int(20, 90),
            //隨機生日
            "birthday" => $this->faker->date(),
            //隨機社團
            "club" => $club
        
        ];
    }

    
}
