<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationalUnit extends Model
{
    use SoftDeletes;

    protected $table = 'operational_units';

    protected $fillable = [
        'name',
    ];

    public function agents()
    {
        return $this->hasMany(Agent::class, 'operational_unit_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
