<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'user_id',
        'rating',
        'text',
    ];

    protected $table = 'reviews';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public static function checkReviewExistance($gameId, $userId) {
        return Review::where('game_id', $gameId)->where('user_id', $userId)->exists();
    }
}
