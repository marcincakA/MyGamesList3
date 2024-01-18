<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListItem extends Model
{
    use HasFactory;
    protected $fillable = [
            'game_id',
            'user_id',
            'status'
        ];
    protected $table = 'list_items';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
