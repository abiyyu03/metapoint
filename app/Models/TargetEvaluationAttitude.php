<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetEvaluationAttitude extends Model
{
    protected $table = 'target_evaluation_attitudes';

    protected $fillable = [
        'name',
    ];
}
