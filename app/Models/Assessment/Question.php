<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['assessment_section_id ', 'question_variable_id', 'value', 'type', 'is_active'];

    public function assessmentSection()
    {
        return $this->belongsTo(AssessmentSection::class, 'assessment_section_id');
    }

    public function questionVariable()
    {
        return $this->belongsTo(QuestionVariable::class, 'question_variable_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
