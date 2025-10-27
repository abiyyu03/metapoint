<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentSection extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['assesment_id', 'name', 'order'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assesment_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
