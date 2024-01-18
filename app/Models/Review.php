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
}
