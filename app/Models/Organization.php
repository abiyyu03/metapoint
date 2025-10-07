<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'name',
    ];

    public function targets()
    {
        return $this->hasMany(Target::class, 'organization_id');
    }

    public function agents()
    {
        return $this->hasMany(Agent::class, 'organization_id');
    }
}
