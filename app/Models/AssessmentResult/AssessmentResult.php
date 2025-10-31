<?php

namespace App\Models\AssessmentResult;

use App\Models\Agent;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

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
