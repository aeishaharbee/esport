<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['matchId', 'teamWon', 'teamLost'];

    public function match()
    {
        return $this->belongsTo(Maatch::class, 'matchId');
    }

    public function winner()
    {
        return $this->belongsTo(Team::class, 'teamWon');
    }

    public function loser()
    {
        return $this->belongsTo(Team::class, 'teamLost');
    }
}
