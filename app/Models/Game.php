<?php

namespace App\Models;

use App\Http\Resources\ListItemResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'publisher',
        'developer',
        'category1',
        'category2',
        'category3',
        'about',
        'image',
        //todo platforms
    ];

    protected $primaryKey = 'game_id';

    public function listItems() {
        return $this->hasMany(ListItem::class);
    }
}
