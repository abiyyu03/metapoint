<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['assesment_section_id', 'value', 'type', 'is_active'];

    public function section()
    {
        return $this->belongsTo(AssessmentSection::class, 'assesment_section_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
