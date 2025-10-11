<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntelligentMethod extends Model
{
    use SoftDeletes;

    protected $table = 'intelligent_methods';

    protected $fillable = [
        'name',
    ];

    public function intelligentMethodOptions()
    {
        return $this->hasMany(IntelligentMethodOption::class, 'method_id');
    }

    public function fundraisingTargets()
    {
        return $this->hasMany(FundraisingTarget::class, 'method_id');
    }
}
