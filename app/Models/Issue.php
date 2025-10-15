<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;
    protected $table = 'issues';

    protected $fillable = [
        'name',
    ];

    public function targets()
    {
        return $this->hasMany(Target::class, 'issue_id');
    }
}
