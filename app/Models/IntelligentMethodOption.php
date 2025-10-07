<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntelligentMethodOption extends Model
{
    protected $table = 'intelligent_method_options';

    protected $fillable = [
        'name',
        'method_id',
    ];

    public function method()
    {
        return $this->belongsTo(IntelligentMethod::class, 'method_id');
    }
}
