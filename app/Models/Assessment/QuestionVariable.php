<?php

namespace App\Models\Assessment;

use App\Models\AssessmentResult\AssessmentResultPartOne;
use App\Models\AssessmentResult\AssessmentResultPartTwo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionVariable extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'dimension'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'question_variable_id');
    }

    public function assessmentResultPartOnes()
    {
        return $this->hasMany(AssessmentResultPartOne::class, 'question_variable_id');
    }

    public function assessmentResultPartTwos()
    {
        return $this->hasMany(AssessmentResultPartTwo::class, 'question_variable_id');
    }
}
