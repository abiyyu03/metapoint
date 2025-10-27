<?php

namespace App\Models\Assessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'description'];

    public function sections()
    {
        return $this->hasMany(AssessmentSection::class, 'assesment_id');
    }
}
