<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function tournaments()
    {
        return $this->hasMany(Tournament::class, 'categoryId');
    }
    public function teams()
    {
        return $this->hasMany(Team::class, 'categoryId');
    }
}
