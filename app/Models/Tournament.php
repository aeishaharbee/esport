<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        "image","name","desc","startDate","endDate","categoryId", 'isActive'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'tournament_teams', 'tournId', 'teamId');
    }
}
