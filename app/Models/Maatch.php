<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'team1Id',
        'team2Id',
        'time',
        'levelId',
        'tournId',
        'isActive',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class,);
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1Id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2Id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'levelId');
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'matchId');
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team1Id', $teamId)
                    ->orWhere('team2Id', $teamId);
    }

}
