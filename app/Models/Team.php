<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        "name","logo","categoryId","registeredId", 'score', 'win', 'lost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'registeredId');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'tournament_teams', 'teamId', 'tournId');
    }

    // public function matches()
    // {
    //     // return $this->hasMany(Maatch::class, 'team1Id')
    //     //             ->orWhere('team2Id', $this->id);
    //     return $this->hasMany(Maatch::class, 'team1Id')
    //             ->orWhere(function($query) {
    //                 $query->where('team2Id', $this->id);
    //             });
    // }

    public function matchesAsTeam1()
    {
        return $this->hasMany(Maatch::class, 'team1Id');
    }

    public function matchesAsTeam2()
    {
        return $this->hasMany(Maatch::class, 'team2Id');
    }

    public function allMatches()
    {
        return Maatch::where('team1Id', $this->id)
                    ->orWhere('team2Id', $this->id);
    }

    public function matches()
    {
        return $this->matchesAsTeam1->merge($this->matchesAsTeam2);
    }

    // Define the relationship for wins
    public function wins()
    {
        return $this->hasMany(Result::class, 'teamWon');
    }

    // Define the relationship for losses
    public function losses()
    {
        return $this->hasMany(Result::class, 'teamLost');
    }
}
