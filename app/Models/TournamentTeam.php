<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentTeam extends Model
{
    use HasFactory;

    protected $table = 'tournament_teams';

    protected $fillable = [
        "teamId","tournId",
    ] ;
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'teamId');
    }
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournId');
    }
}
