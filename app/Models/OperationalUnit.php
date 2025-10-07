<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OperationalUnit extends Model
{
    use SoftDeletes;

    protected $table = 'issues';

    protected $fillable = [
        'name',
    ];
}
