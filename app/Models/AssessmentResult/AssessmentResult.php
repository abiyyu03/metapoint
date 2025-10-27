<?php

namespace App\Models\AssessmentResult;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentResult extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'target_id',
        'agent_id',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    public function sections()
    {
        return $this->hasMany(AssessmentResultSection::class, 'assessment_result_section_id');
    }

    public function assessmentResultPartOnes()
    {
        return $this->hasMany(AssessmentResultPartOne::class, 'assessment_result_id');
    }

    public function assessmentResultPartTwos()
    {
        return $this->hasMany(AssessmentResultPartTwo::class, 'assessment_result_id');
    }
}
