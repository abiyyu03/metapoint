<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Title extends Model
{
    use SoftDeletes;
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