<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetEvaluationAttitude extends Model
{
    use SoftDeletes;
    protected $table = 'target_evaluation_attitudes';

    protected $fillable = [
        'name',
    ];
}
