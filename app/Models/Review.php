<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'score', 'is_approved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localGame()
    {
        return $this->belongsTo(LocalGame::class, 'game_id');
    }
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function response()
    {
        return $this->hasOne(Response::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}

