<?php

namespace App\Models\AssessmentResult;

use App\Models\Assessment\QuestionVariable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentResultPartOne extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'assessment_result_section_id',
        'assessment_result_id',
        'question_variable_id',
        'result_type',
        'index',
        'value',
        'category',
    ];

    public function section()
    {
        return $this->belongsTo(AssessmentResultSection::class, 'assessment_result_section_id');
    }

    public function questionVariable()
    {
        return $this->belongsTo(QuestionVariable::class, 'question_variable_id');
    }

    public function assessmentResult()
    {
        return $this->belongsTo(AssessmentResult::class, 'assessment_result_id');
    }
}
