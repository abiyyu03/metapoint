<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;
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
