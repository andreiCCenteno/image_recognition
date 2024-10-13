<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameState extends Model
{
    // Define the properties and methods relevant to the game state
    protected $fillable = ['level', 'playerHp', 'monsterHp'];
}
