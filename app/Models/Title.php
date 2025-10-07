<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'titles';

    protected $fillable = [
        'name',
    ];

    public function targets()
    {
        return $this->hasMany(Target::class, 'title_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class, 'title_id');
    }
}