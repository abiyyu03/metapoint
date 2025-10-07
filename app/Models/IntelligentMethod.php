<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntelligentMethod extends Model
{
    protected $table = 'intelligent_methods';

    protected $fillable = [
        'name',
    ];

    public function intelligentMethodOptions()
    {
        return $this->hasMany(IntelligentMethodOption::class, 'method_id');
    }
}
