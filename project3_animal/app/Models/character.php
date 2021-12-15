<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class character extends Model
{
    use HasFactory;

    //允許被寫入的屬性
    protected $fillable = [
        "serialid",
        "char_name",
        "char_name_spell",
        "gender",
        "char_height",
        "char_weight",
        "birthday",
        "club",
        "description",
        "battle_relate",
    ];
}
