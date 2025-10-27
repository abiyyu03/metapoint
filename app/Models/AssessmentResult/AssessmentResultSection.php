<?php

namespace App\Models\AssessmentResult;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentResultSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
    ];

    public function assessmentResultPartOnes()
    {
        return $this->hasMany(AssessmentResultPartOne::class);
    }

    public function assessmentResultPartTwos()
    {
        return $this->hasMany(AssessmentResultPartTwo::class);
    }
}
