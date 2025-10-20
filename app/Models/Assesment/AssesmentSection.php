<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssesmentSection extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['assesment_id', 'name', 'order'];

    public function assesment()
    {
        return $this->belongsTo(Assesment::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
