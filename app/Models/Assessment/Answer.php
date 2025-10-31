<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['question_id', 'label_option', 'order', 'label', 'value'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
