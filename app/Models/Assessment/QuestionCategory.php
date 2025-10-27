<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
